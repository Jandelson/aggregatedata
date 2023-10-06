<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

it('uploads and processes files successfully', function () {
    Storage::fake('temp');

    $files = [
        new SymfonyUploadedFile(__DIR__.'/test_files/file1.csv', 'file1.csv', 'text/csv', null, true),
        new SymfonyUploadedFile(__DIR__.'/test_files/file2.csv', 'file2.csv', 'text/csv', null, true),
    ];

    $uploadedFiles = [];
    foreach ($files as $file) {
        $uploadedFile = new UploadedFile(
            $file->getPathname(),
            $file->getClientOriginalName(),
            $file->getClientMimeType(),
            $file->getSize(),
            null,
            true
        );
        $uploadedFiles[] = $uploadedFile;

        $this->postJson('/upload', ['files' => [$uploadedFile]])
            ->assertSuccessful();
    }

    $process = new \Symfony\Component\Process\Process(['python3',  base_path() . '/python/script.py', json_encode($uploadedFiles)]);
    $process->run();

    expect($process->isSuccessful())->toBeTrue();
});