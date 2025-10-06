<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PreferenceController;
use App\Http\Controllers\Api\V1\PreferredArticleController;
use Illuminate\Support\Facades\Route;

Route::as('api.v1.')
    ->prefix('v1')
    ->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

        Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('articles/preferred', [PreferredArticleController::class, 'index'])->name('articles.preferred.index');

            Route::get('preferences', [PreferenceController::class, 'show'])->name('preferences.show');
            Route::put('preferences', [PreferenceController::class, 'update'])->name('preferences.update');
        });
    });
