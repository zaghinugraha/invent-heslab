<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readAllAdmin()
    {
        auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewRentRequest')->markAsRead();
        auth()->user()->unreadNotifications->where('type', 'App\Notifications\DocumentationCompletedNotification')->markAsRead();

        return redirect()->back()->with('success', 'Notifications marked as read.');
    }

    public function readAllReg()
    {
        auth()->user()->unreadNotifications->where('type', 'App\Notifications\RentApprovedNotification')->markAsRead();
        auth()->user()->unreadNotifications->where('type', 'App\Notifications\RentRejectedNotification')->markAsRead();

        return redirect()->back()->with('success', 'Notifications marked as read.');
    }
}
