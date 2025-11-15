<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\FIleController;
use App\Http\Controllers\OnboardingServiceController;
use App\Http\Controllers\VisaServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function ($router) {

    Route::prefix('admin')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', [AdminAuthController::class, 'login']);
        });

        Route::middleware('auth:admin')->group(function () {

            Route::prefix('auth')->group(function () {
                Route::get('/', [AdminAuthController::class, 'show']);
                Route::put('/', [AdminAuthController::class, 'update']);
            });

            Route::prefix('categories')->group(function () {
                Route::get('/', [CategoryController::class, 'index']);
                Route::post('/', [CategoryController::class, 'store']);
                Route::get('/{id}', [CategoryController::class, 'show']);
                Route::put('/{id}', [CategoryController::class, 'update']);
                Route::delete('/{id}', [CategoryController::class, 'destroy']);
                Route::post('/restore/{id}', [CategoryController::class, 'restore']);
            });

            Route::prefix('category-service')->group(function () {
                Route::get('/', [CategoryServiceController::class, 'index']);
                Route::post('/', [CategoryServiceController::class, 'store']);
                Route::get('/{id}', [CategoryServiceController::class, 'show']);
                Route::put('/{id}', [CategoryServiceController::class, 'update']);
                Route::delete('/{id}', [CategoryController::class, 'destroy']);
                Route::post('/restore/{id}', [CategoryServiceController::class, 'restore']);
            });

            Route::prefix('customer')->group(function () {
                Route::get('/', [CustomerController::class, 'index']);
                Route::post('/', [CustomerController::class, 'store']);
                Route::get('/{id}', [CustomerController::class, 'show']);
                Route::post('/{id}', [CustomerController::class, 'update']);
                Route::delete('/{id}', [CustomerController::class, 'destroy']);
                Route::post('/restore/{id}', [CustomerController::class, 'restore']);
            });

            Route::prefix('employer')->group(function () {
                Route::get('/', [EmployerController::class, 'index']);
                Route::post('/', [EmployerController::class, 'store']);
                Route::get('/{id}', [EmployerController::class, 'show']);
                Route::post('/{id}', [EmployerController::class, 'update']);
                Route::post('/restore/{id}', [EmployerController::class, 'restore']);
            });

            Route::prefix('download')->group(function () {
                Route::get('/{name}', [FileController::class, 'download']);
            });

            Route::prefix('onboarding-service')->group(function () {
                Route::get('/', [OnboardingServiceController::class, 'index']);
                Route::post('/', [OnboardingServiceController::class, 'store']);
                Route::get('/{id}', [OnboardingServiceController::class, 'show']);
            });

            Route::prefix('visa-services')->group(function () {
                Route::get('/', [VisaServiceController::class, 'index']);
                Route::post('/', [VisaServiceController::class, 'store']);
                Route::get('/{id}', [VisaServiceController::class, 'show']);
                Route::post('/{id}', [VisaServiceController::class, 'update']);
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
