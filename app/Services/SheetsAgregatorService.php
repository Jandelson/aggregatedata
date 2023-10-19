<?php

namespace App\Services;

use App\Models\Destination;
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
        $process = new Process(
            [
                'python3',
                base_path() . '/python/script.py',
                json_encode($filesPath),
                $this->getConfigDestination()
            ]
        );
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error($process->getOutput());
            Log::error($process->getErrorOutput());
            return response()->json(['error' => 'Failed to process agregate files'], 500);
        }

        $returnPython = explode('--separator--', trim($process->getOutput()));
        $linkDownloadFile = $returnPython[0];
        $msgSuccess = 'File agragated successfully' . '<br>' . $returnPython[1] ?? '';

        $this->removeFilesUpload($filesPath);

        return response()->json([
            'success' => $msgSuccess,
            'link' => $linkDownloadFile
        ]);
    }

    private function getConfigDestination()
    {
        $destination = Destination::where('enable', '1')->first();

        if (!$destination) {
            return '{}';
        }

        if ($destination) {
            return '{
                    "host": "' . $destination->host . '",
                    "db_name": "' . $destination->database .'",
                    "user_name": "' . $destination->user .'",
                    "password": "' . $destination->password .'",
                    "table_name": "' . $destination->table_name .'",
                    "if_exists": "' . $destination->if_exists .'"
                }';
        }
    }
}
