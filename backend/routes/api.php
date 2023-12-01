<?php

use App\Http\Controllers\{AuthController, ImageController, GalleryController, SearchController};
use App\Http\Middleware\Auth;
use App\Http\Middleware\CheckOwnership;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware(Auth::class)->post('logout', [AuthController::class, 'logout']);

Route::middleware(Auth::class)->prefix('/images')->group(function () {


    Route::post('/', [ImageController::class, 'store']);
    Route::get('/', [ImageController::class, 'index']);

    Route::post('/{image}/tags', [ImageController::class, 'addTags'])
        ->middleware(CheckOwnership::class);
    Route::delete('/{image}/tags', [ImageController::class, 'removeTags'])
        ->middleware(CheckOwnership::class);

    Route::get('/{image}', [ImageController::class, 'show'])
        ->middleware(CheckOwnership::class);

    Route::delete('/{image}', [ImageController::class, 'destroy'])
        ->middleware(CheckOwnership::class);
});

Route::middleware(Auth::class)->prefix('/galleries')->group(function () {

    Route::post('/', [GalleryController::class, 'store']);
    Route::get('/', [GalleryController::class, 'index']);

    Route::get('/{gallery}', [GalleryController::class, 'show'])
        ->middleware(CheckOwnership::class);

    Route::post('/{gallery}', [GalleryController::class, 'addImage'])
        ->middleware(CheckOwnership::class);

    Route::delete('/{gallery}', [GalleryController::class, 'destroy'])
        ->middleware(CheckOwnership::class);

    Route::delete('/{gallery}/images', [GalleryController::class, 'removeImage'])
        ->middleware(CheckOwnership::class);

    Route::post('/{gallery}/tags', [GalleryController::class, 'addTags'])
        ->middleware(CheckOwnership::class);

        Route::delete('/{gallery}/tags', [GalleryController::class, 'removeTags'])
        ->middleware(CheckOwnership::class);

});

Route::middleware(Auth::class)->get('search', [SearchController::class,'search']);

