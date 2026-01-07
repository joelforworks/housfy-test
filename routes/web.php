<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanetController;

Route::get('/', [PlanetController::class, 'index'])->name('home');
