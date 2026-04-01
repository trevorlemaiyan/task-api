<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/', [TaskController::class, 'index']);
    Route::patch('/{task}/status', [TaskController::class, 'updateStatus']);
    Route::delete('/{task}', [TaskController::class, 'destroy']);
    Route::get('/report', [TaskController::class, 'report']); 
});