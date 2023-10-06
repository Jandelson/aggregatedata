<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Services\SheetsAgregatorService;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SheetsAgregateController extends Controller
{
    public function __construct(
        private SheetsAgregatorService $sheetsAgregatorService
    ) {}
    public function uploadFiles(UploadFileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $response = $this->sheetsAgregatorService->handleFiles($validated['files']);
        $data = json_decode($response->getContent(), true);
        return redirect()->back()->with($data);
    }
    public function download(string $name): Response
    {
        return $this->sheetsAgregatorService->download($name);
    }
}
