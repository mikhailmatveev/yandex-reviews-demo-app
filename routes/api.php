<?php

use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/reviews', [ReviewController::class, 'show']);
    Route::get('/integration', [IntegrationController::class, 'show']);
    Route::post('/integration', [IntegrationController::class, 'store']);
    Route::post('/integration/sync', [IntegrationController::class, 'sync']);
});
