<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\GenerateHistoriqueController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\GenerateController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/auth'], function ($router) {
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('register', [AuthController::class, 'register']);
    Route::middleware('jwt')->group(function() {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
})->middleware('cors');

Route::prefix('v1')->middleware(['jwt','checkPermission','cors'])->group(function () {

   /* Roles Route */
    Route::group(['prefix' => 'roles'], function(){
        Route::get('all', [RoleController::class, 'all']);
        Route::delete('delete-multiple', [RoleController::class, 'deleteMultiple']);
    });
    Route::resource('roles', RoleController::class)->except(['create', 'edit']);
    /* ----------- */
    /* Users Route */
    Route::group(['prefix' => 'users'], function(){
        Route::get('all', [UserController::class, 'all']);
        Route::delete('delete-multiple', [UserController::class, 'deleteMultiple']);
    });
    Route::resource('users', UserController::class)->except(['create', 'edit']);
    /* ----------- */

    /* Permission Route */
    Route::group(['prefix' => 'permissions'], function(){
        Route::get('all', [PermissionController::class, 'all']);
        Route::delete('delete-multiple', [PermissionController::class, 'deleteMultiple']);
        Route::post('create-module-permission', [PermissionController::class, 'createModulePermission']);
    });
    Route::resource('permissions', PermissionController::class)->except(['create', 'edit']);
    /* ----------- */
    /* Permission Route */
    Route::group(['prefix' => 'products'], function(){
        Route::get('all', [ProductController::class, 'all']);
        Route::delete('delete-multiple', [ProductController::class, 'deleteMultiple']);
    });
    Route::resource('products', ProductController::class)->except(['create', 'edit']);
    /* ----------- */
    /* Generate Route */
    Route::group(['prefix' => 'generate'], function(){
        Route::post('/content', [GenerateController::class, 'generateContent']);
        Route::post('/social-media-post', [GenerateController::class, 'generateSocialMediaPostDescription']);
        Route::post('/seo-content', [GenerateController::class, 'generateProductSEOContent']);
        Route::post('/product-description', [GenerateController::class, 'generateProductDescription']);
    });
    /* ----------- */
    /* Generate Historique Route */
    Route::group(['prefix' => 'generate-historiques'], function(){
        Route::get('all', [GenerateHistoriqueController::class, 'all']);
        Route::delete('delete-multiple', [GenerateHistoriqueController::class, 'deleteMultiple']);
    });
    Route::resource('generate-historiques', GenerateHistoriqueController::class)->except(['create', 'edit']);
    /* ----------- */
});
