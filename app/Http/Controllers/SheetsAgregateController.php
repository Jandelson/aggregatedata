<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;

class SheetsAgregateController extends Controller
{
    public function uploadFiles(UploadFileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $response = $this->handleFiles($validated['files']);
        $data = json_decode($response->getContent(), true);
        return redirect()->back()->with($data);
    }
    public function download(string $name): Response
    {
        return response()->download('/tmp' . '/' . $name);
    }

    private function handleFiles(array $files): Response
    {
        $filesPath = [];
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $filesPath[] = storage_path() . '/' . 'app/' . $file->storeAs('temp', $fileName);
        }

        return $this->processAgregate($filesPath);
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
