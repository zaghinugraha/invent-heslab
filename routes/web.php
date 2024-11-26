<?php

use App\Http\Controllers\AdminHistoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminRentController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/reg/rent', [RentController::class, 'fetch'])->name('dashboard-reg-rent');

    Route::get('/reg/history', [RentController::class, 'history'])->name('dashboard-reg-history');

    // Route for Rent
    Route::get('/rent/create', [RentController::class, 'createInvoice'])->name('rent.create');
    Route::post('/rent', [RentController::class, 'store'])->name('rent.store');
    Route::get('/rent/{id}', [RentController::class, 'show'])->name('rent.show');
    Route::post('/rent/documentation', [RentController::class, 'submitDocumentation'])->name('rent.documentation');
    Route::delete('/rent/{rent}/cancel', [RentController::class, 'cancel'])->name('rent.cancel');



    //  Route for Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/test', [CartController::class, 'testCart']);
    Route::get('/session/test', [CartController::class, 'checkSession']);



    //    Routes for product
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/reg/items', [ProductController::class, 'user_dashboard'])->name('dashboard-reg-items');
    Route::get('/admin/items', [ProductController::class, 'admin_dashboard'])->name('dashboard-admin-items');
    Route::get('/products/{id}', [ProductController::class, 'showByID'])->name('products.showByID');
    Route::get('/product/image/{uuid}', [ProductController::class, 'getImage'])->name('product.image');

    Route::post('/reg/notifications/mark-all-read', [NotificationController::class, 'readAllReg'])
        ->name('notifications.readAllReg');


    Route::middleware(['check.admin.team'])->group(function () {
        Route::post('/admin/notifications/mark-all-read', [NotificationController::class, 'readAllAdmin'])
            ->name('notifications.readAllAdmin');

        Route::get('/admin/history', [AdminHistoryController::class, 'history'])->name('dashboard-admin-history');

        Route::get('/admin/rent', [AdminRentController::class, 'index'])->name('dashboard-admin-rent');
        Route::post('/admin/rent-requests/{rent}/approve', [AdminRentController::class, 'approve'])->name('rent.approve');
        Route::post('/admin/rent-requests/{rent}/reject', [AdminRentController::class, 'reject'])->name('rent.reject');
        Route::post('/admin/rent-requests/{rent}/returned', [AdminRentController::class, 'returned'])->name('rent.return');
        Route::post('/admin/rent-requests/{rent}/invalid', [AdminRentController::class, 'invalid'])->name('rent.invalid');
        Route::get('/admin/rent/{id}/ktm-image', [AdminRentController::class, 'getKtmImage'])->name('rent.ktmImage');
        Route::get('/admin/rent/{id}/before-documentation', [AdminRentController::class, 'getBeforeDocumentation'])->name('rent.beforeDocumentation');
        Route::get('/admin/rent/{id}/after-documentation', [AdminRentController::class, 'getAfterDocumentation'])->name('rent.afterDocumentation');
        Route::get('/admin/rent/{id}/details', [RentController::class, 'show'])->name('rent.details');

        Route::get('/admin/items', [ProductController::class, 'admin_dashboard'])->name('dashboard-admin-items');
        Route::resource('/products', ProductController::class);

        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::resource('/categories', CategoryController::class);

        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    });
});
