<?php

use App\Http\Controllers\SheetsAgregateController;
use App\Http\Requests\UploadFileRequest;
use App\Services\SheetsAgregator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\withoutMiddleware;

// Tests for SheetsAgregateController
it('should upload files and redirect back with success message', function () {
    // Mock the SheetsAgregator class
    $sheetsAgregatorMock = Mockery::mock(SheetsAgregator::class);
    $sheetsAgregatorMock->shouldReceive('handleFiles')
        ->once()
        ->andReturn(response()->json(['success' => 'File aggregated successfully']));

    // Create a new instance of the controller with the mocked SheetsAgregator dependency
    $controller = new SheetsAgregateController($sheetsAgregatorMock);

    // Create an upload request with a test file
    $file = UploadedFile::fake()->create('test.xlsx');
    $request = UploadFileRequest::create('/upload', 'POST', ['files' => [$file]]);

    // Make the request to the controller
    actingAs(factory(User::class)->create());
    $response = $controller->uploadFiles($request);

    // Assert that the response is a redirect and contains the success message
    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->getSession()->get('success'))->toBe('File aggregated successfully');
});