<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ItemController;

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



    Route::get('/reg/items/{id}', [ItemController::class, 'show'])->name('items.show');

    Route::middleware(['check.admin.team'])->group(function () {
        Route::get('/admin/history', function () {
            return view('dashboard-admin-history');
        })->name('dashboard-admin-history');

        Route::get('/admin/rent', function () {
            return view('dashboard-admin-rent');
        })->name('dashboard-admin-rent');

        Route::get('/admin/items', [ItemController::class, 'showAllAdmin'])->name('dashboard-admin-items');
        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/promote', [UserController::class, 'promote'])->name('users.promote');
        Route::post('/users/{user}/demote', [UserController::class, 'demote'])->name('users.demote');
        Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    });
});