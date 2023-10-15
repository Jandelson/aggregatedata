<?php

namespace Tests\Feature;

use App\Http\Controllers\SheetsAgregateController;
use App\Http\Requests\UploadFileRequest;
use App\Services\SheetsAgregatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SheetsAgregateControllerTest extends TestCase
{
    public function testUploadFiles()
    {
        // Create a mock SheetsAgregatorService
        $sheetsAgregatorServiceMock = $this->createMock(SheetsAgregatorService::class);

        // Set up the mock to return a fake response
        $fakeResponse = response()->json(['success' => true]);
        $sheetsAgregatorServiceMock->expects($this->once())
            ->method('handleFiles')
            ->willReturn($fakeResponse);

        // Create a mock UploadFileRequest with some fake data
        $fakeRequestData = ['files' => ['file1.csv', 'file2.csv']];
        $fakeRequest = UploadFileRequest::create('/upload', 'POST', $fakeRequestData);

        // Create a new SheetsAgregateController and call the uploadFiles method
        $controller = new SheetsAgregateController($sheetsAgregatorServiceMock);
        $response = $controller->uploadFiles($fakeRequest);

        // Verify that the response is a RedirectResponse
        $this->assertInstanceOf(RedirectResponse::class, $response);

        // Verify that the response redirects back and includes the fake response data
        $this->assertTrue(session()->has('success'));
        $this->assertEquals(session('success'), true);
    }
}
