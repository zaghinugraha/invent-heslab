<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/reg/items', function () {
        return view('dashboard-reg-items');
    })->name('dashboard-reg-items');

    Route::middleware(['check.admin.team'])->group(function () {

        Route::get('/admin/history', function () {
            return view('dashboard-admin-history');
        })->name('dashboard-admin-history');

        Route::get('/admin/rent', function () {
            return view('dashboard-admin-rent');
        })->name('dashboard-admin-rent');

        Route::get('/admin/items', function () {
            return view('dashboard-admin-items');
        })->name('dashboard-admin-items');

        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/promote', [UserController::class, 'promote'])->name('users.promote');
        Route::post('/users/{user}/demote', [UserController::class, 'demote'])->name('users.demote');
        Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    });
});