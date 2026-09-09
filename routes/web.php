<?php

use App\Http\Controllers\TreesController;
use Illuminate\Support\Facades\Route;

Route::get('/api/trees', [TreesController::class, 'index']);
Route::get('/api/tree/{id}', [TreesController::class, 'show']);
Route::get('/api/add/tree', [TreesController::class, 'store']);
//Route::post('/api/add/tree', [TreesController::class, 'store']);
