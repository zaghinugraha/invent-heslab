<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard-admin-history', function () {
        return view('dashboard-admin-history');
    })->name('dashboard-admin-history');

    Route::get('/dashboard-admin-rent', function () {
        return view('dashboard-admin-rent');
    })->name('dashboard-admin-rent');
});


