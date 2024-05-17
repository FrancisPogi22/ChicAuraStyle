<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AlreadyAuthenticated;
use Illuminate\Support\Facades\Route;

Route::middleware(AlreadyAuthenticated::class)->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
    Route::get('/register', function () {
        return view('register');
    })->name('register');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register')->name('register.user');
    Route::post('/login', 'login')->name('login.user');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(MainController::class)->group(function () {
        Route::get('/homepage', 'homepage')->name('homepage');
        Route::get('/admin/homepage', 'homepage')->name('admin.homepage');
        Route::get('/products', 'products')->name('get.products');
        Route::get('/getByCategory', 'getByCategory')->name('get.product.category');
        Route::get('/getByPrice', 'getByPrice')->name('get.product.price');
        Route::post('/addOrder', 'addOrder')->name('add.order');
        Route::get('/orders', 'orders')->name('orders');
        Route::post('/checkout', 'checkout')->name('check.out');
        Route::delete('/removeProduct', 'removeProduct')->name('remove.product');
        Route::post('/updateProduct', 'updateProduct')->name('product.update');
        Route::post('/addProduct', 'addProduct')->name('product.add');
    });
    

    Route::controller(UserController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
    });
});
