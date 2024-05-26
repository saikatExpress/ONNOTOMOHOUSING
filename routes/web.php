<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'Storage Link Successfully';
});

Route::get('/clear', function(){
    Artisan::call('optimize:clear');
    return 'Optimize Clear!.';
})->name('clear');

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');


Route::controller(AuthController::class)->group(function(){
    Route::get('/', 'login')->name('login');
    Route::get('/sign/up', 'signUp')->name('sign.up');
    Route::post('/log/store', 'authCheck')->name('log.store');
});

Route::middleware(['auth'])->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/user/dashboard', 'index')->name('user.dashboard');
        Route::get('/user/profile', 'userProfile')->name('user.profile');
        Route::post('/profile/update', 'update')->name('profile.update');
    });

    Route::controller(PaymentController::class)->group(function(){
        Route::get('/payment', 'index')->name('payment');
        Route::post('/payment/store', 'store')->name('payment.store');
    });

    Route::controller(BillingController::class)->group(function(){
        Route::get('/billing', 'index')->name('billing');
    });
});

Route::middleware(['auth'])->group(function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/dashboard', 'adminDashBoard')->name('admin.dashboard');
        Route::get('/user/list', 'index')->name('user.list');
        Route::get('/create/user', 'create')->name('create.user');
        Route::post('/user/store', 'store')->name('user.store');
    });


    Route::controller(BillingController::class)->group(function(){
        Route::get('/user/payment', 'billIndex')->name('user.payment');
    });

    Route::controller(PaymentController::class)->group(function(){
        Route::get('/give/approve/payment/{id}', 'giveApprovePayment');
        Route::post('/save/payment', 'savePayment')->name('payment.save');
        Route::post('/payment/update/{id}', 'update');
        Route::get('/fetch/payment/{id}', 'show');
        Route::get('/delete/payment/{id}', 'destroy');
    });
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout.us');
