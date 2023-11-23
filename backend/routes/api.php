<?php

use App\Http\Controllers\{AuthController,ImageController, GalleryController};
use App\Http\Middleware\CheckImageOwner;
use Illuminate\Support\Facades\Route;


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

Route::prefix('/galleries')->group(function (){
    
    Route::post('/', [GalleryController::class,'store']);
    Route::get('/', [GalleryController::class,'index']);
});

/**
 * create a gallery
 * show user galleries
 * show a gallery
 * delete a gallery
 * add image to a gallery
 * remove a gallery
 */