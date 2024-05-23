<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
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
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/dashboard', 'adminDashBoard')->name('admin.dashboard');
        Route::get('/user/list', 'index')->name('user.list');
        Route::get('/create/user', 'create')->name('create.user');
        Route::post('/user/store', 'store')->name('user.store');
    });
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout.us');
