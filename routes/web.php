<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [RedirectController::class, 'index'])->name('dashboard');
    Route::get('/reg/items', [ItemController::class, 'showAllRegular'])->name('dashboard-reg-items');
    Route::get('/reg/rent', function () {
        return view('dashboard-reg-rent');
    })->name('dashboard-reg-rent');

    Route::get('/reg/history', function () {
        return view('dashboard-reg-history');
    })->name('dashboard-reg-history');


    //  Route for Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/test', [CartController::class, 'testCart']);
    Route::get('/session/test', [CartController::class, 'checkSession']);



    //    Routes for product
    Route::get('/reg/items', [ProductController::class, 'user_dashboard'])->name('dashboard-reg-items');
    Route::get('/admin/items', [ProductController::class, 'admin_dashboard'])->name('dashboard-admin-items');
    Route::get('/products/{id}', [ProductController::class, 'showByID'])->name('products.showByID');
    Route::get('/product/image/{uuid}', [ProductController::class, 'getImage'])->name('product.image');
    Route::resource('/products', ProductController::class);



    Route::middleware(['check.admin.team'])->group(function () {
        Route::get('/admin/history', function () {
            return view('dashboard-admin-history');
        })->name('dashboard-admin-history');

        Route::get('/admin/rent', function () {
            return view('dashboard-admin-rent');
        })->name('dashboard-admin-rent');

        Route::get('/admin/items', [ItemController::class, 'showAllAdmin'])->name('dashboard-admin-items');
        Route::get('/admin/items', [ProductController::class, 'admin_dashboard'])->name('dashboard-admin-items');
        Route::resource('/products', ProductController::class);

        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::resource('categories', CategoryController::class);

        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/promote', [UserController::class, 'promote'])->name('users.promote');
        Route::post('/users/{user}/demote', [UserController::class, 'demote'])->name('users.demote');
        Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    });
});
