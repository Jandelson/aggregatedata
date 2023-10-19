<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SheetsAgregateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/sheets_agragate', function() {
        return view('sheets-agregate');
    })->name('sheets-agragate');

    Route::post('/upload_sheets', [SheetsAgregateController::class, 'uploadFiles'])->name('upload-sheets');
    Route::get('/download/{name?}', [SheetsAgregateController::class, 'download'])->name('download');

    Route::get('/destination', [DestinationController::class, 'index'])->name('destination');
    Route::post('destination/store', [DestinationController::class, 'store'])->name('destination-store');
    Route::post('destination/update', [DestinationController::class, 'update'])->name('destination-update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

