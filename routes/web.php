<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetectionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog');

Route::get('/deteksi', [DetectionController::class, 'index']);
Route::post('/detect', [DetectionController::class, 'detect']);
