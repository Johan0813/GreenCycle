<?php

use App\Http\Controllers\ArbolesController;
use Illuminate\Support\Facades\Route;

Route::get('/api/arboles', [ArbolesController::class, 'index']);
Route::get('/api/arboles/{id}', [ArbolesController::class, 'show']);
Route::get('/api/arboles', [ArbolesController::class, 'create']);