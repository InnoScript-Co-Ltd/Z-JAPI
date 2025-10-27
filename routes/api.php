<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VisaServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function ($router) {
    // Route::prefix('auth')->group(function () {
    //     Route::post('login', [UserAuthController::class, 'login']);
    // });

    // Route::middleware('auth:api')->group(function () {

    //     Route::prefix('auth')->group(function () {
    //         Route::get('/', [UserAuthController::class, 'show']);
    //         Route::put('/', [UserAuthController::class, 'update']);
    //     });
    // });

    Route::prefix('admin')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', [AdminAuthController::class, 'login']);
        });

        Route::middleware('auth:admin')->group(function () {

            Route::prefix('auth')->group(function () {
                Route::get('/', [AdminAuthController::class, 'show']);
                Route::put('/', [AdminAuthController::class, 'update']);
            });

            Route::prefix('visa-services')->group(function () {
                Route::get('/', [VisaServiceController::class, 'index']);
                Route::post('/', [VisaServiceController::class, 'store']);
                Route::get('/{id}', [VisaServiceController::class, 'show']);
                Route::post('/{id}', [VisaServiceController::class, 'update']);
            });

            Route::prefix('customer')->group(function () {
                Route::get('/', [CustomerController::class, 'index']);
                Route::post('/', [CustomerController::class, 'store']);
                Route::get('/{id}', [CustomerController::class, 'show']);
                Route::post('/{id}', [CustomerController::class, 'update']);
                Route::delete('/{id}', [CustomerController::class, 'destroy']);
                Route::post('/restore/{id}', [CustomerController::class, 'restore']);
            });

            Route::prefix('activities')->group(function () {
                Route::get('/', [ActivityController::class, 'index']);
                Route::post('/delete/multiple', [ActivityController::class, 'destryMultiple']);
            });

            Route::prefix('user')->group(function () {
                Route::post('/', [UserController::class, 'store']);
                Route::get('/', [UserController::class, 'index']);
                Route::get('/{id}', [UserController::class, 'show']);
                Route::put('/{id}', [UserController::class, 'update']);
                Route::delete('/{id}', [UserController::class, 'destroy']);
            });

            Route::put('/approve/{id}', [AdminController::class, 'approve']);
            Route::post('/restore/{id}', [AdminController::class, 'restore']);
            Route::get('/trash', [AdminController::class, 'delIndex']);
            Route::get('/', [AdminController::class, 'index']);
            Route::get('/{id}', [AdminController::class, 'show']);
            Route::put('/{id}', [AdminController::class, 'update']);
            Route::post('/', [AdminController::class, 'store']);
            Route::delete('/{id}', [AdminController::class, 'destroy']);
        });
    });
});
