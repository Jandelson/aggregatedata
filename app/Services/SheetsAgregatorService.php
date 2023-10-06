<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;

class SheetsAgregatorService
{
    public function handleFiles(array $files): Response
    {
        $filesPath = [];
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $filesPath[] = storage_path() . '/' . 'app/' . $file->storeAs('temp', $fileName);
        }

        $result =  $this->processAgregate($filesPath);
        
        $this->removeFilesUpload($filesPath);

        return $result;
    }

    public function download(string $name): BinaryFileResponse
    {
        $filePath = '/tmp' . '/' . $name;
        return response()->download($filePath);
    }

    private function removeFilesUpload(array $filesPath): void
    {
        foreach ($filesPath as $filePath) {
            Storage::delete($filePath);
        }
    }

    private function processAgregate(array $filesPath): Response
    {
        $process = new Process(['python3',  base_path() . '/python/script.py', json_encode($filesPath)]);
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error($process->getOutput());
            Log::error($process->getErrorOutput());
            return response()->json(['error' => 'Failed to process agregate files'], 500);
        }

        $linkDownloadFile = trim($process->getOutput());

        $this->removeFilesUpload($filesPath);

        return response()->json([
            'success' => 'File agragated successfully',
            'link' => $linkDownloadFile
        ]);
    }
}
