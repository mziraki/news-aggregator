<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\PreferenceController;
use App\Http\Controllers\Api\V1\PreferredArticleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('articles', [ArticleController::class, 'index']);
    Route::get('articles/preferred', [PreferredArticleController::class, 'index'])->middleware('auth:sanctum');
    Route::get('articles/{article}', [ArticleController::class, 'show']);

    Route::get('preferences', [PreferenceController::class, 'show'])->middleware('auth:sanctum');
    Route::put('preferences', [PreferenceController::class, 'update'])->middleware('auth:sanctum');
});
