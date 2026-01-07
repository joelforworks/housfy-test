<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

Route::post('/logs/send', [LogController::class, 'store'])->name('send');
Route::get('/logs/{vehicle}', [LogController::class, 'logs'])->name('logs');
Route::get('/logs/generate-obstacles/{planet}', [LogController::class, 'generateObstacles'])->name('obstacles');
