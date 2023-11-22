<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Middleware\CheckImageOwner;
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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::prefix('/images')->group(function () {
  
    
    Route::post('/', [ImageController::class, 'store']);
    Route::get('/', [ImageController::class, 'index']);
    
    Route::get('/{image}', [ImageController::class, 'show'])
    ->middleware(CheckImageOwner::class);

    Route::delete('/{image}', [ImageController::class,'destroy'])
    ->middleware(CheckImageOwner::class);
    
});