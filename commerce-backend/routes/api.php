<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\EmailVerificationController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\customer\AuthController as CustomerAuthController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\customer\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1/admin')->group(function () {

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::controller(AuthController::class)->group(function () {
            Route::post('/user', 'getUser');
            Route::post('/register', 'createAccount');
        });

        Route::controller(CustomerAuthController::class)->group(function () {
            Route::post('/customer', 'getUser');
            Route::post('/customer/register', 'createAccount');
        });

        Route::controller(CustomerController::class)->group(function () {
            Route::put('/customer/{id}/lock', 'lockAndUnlock');
            Route::get('/customer/{id}', 'showCustomer');
            Route::post('/customer-addresses', 'storeOrUpdateCustomerAddresses');
        });

        Route::controller(EmailVerificationController::class)->group(function () {
            Route::post('/send-verification-email', 'sendVerificationEmail');
            Route::post('/verify-token', 'verifyToken');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('/admin-users', 'getAdminUsers');
            Route::get('/customers', 'getCustomers');
            Route::delete('/admin-users/{id}', 'deleteUser');
            Route::get('/admin-users/{id}', 'showUser');
            Route::put('/admin-users/{id}/password', 'updateUserPassword');
            Route::put('/admin-users/{id}/user', 'updateUser');
        });

        Route::controller(PermissionController::class)->group(function () {
            Route::get('/admin-users/{user}/permissions', 'index');
            Route::post('/admin-users/{user}/permissions', 'update');
            Route::delete('/admin-users/{user}/permissions/{page}', 'destroy');
        });

        Route::controller(PageController::class)->group(function () {
            Route::get('/page', 'index');
            Route::post('/page', 'addPage');
        });

        Route::controller(OrderController::class)->group(function () {
            Route::get('/customers/{customerId}/orders', 'getCustomerOrders');
            Route::get('/orders', 'getOrders');
        });
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'authenticate');
        // Route::post('/register', 'createAccount');
    });
});
