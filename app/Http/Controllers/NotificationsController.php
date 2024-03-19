<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;

        return view('notifications.index', compact('notifications'));
    }

    public function mark_all()
    {
        if(auth()->user()->unreadNotifications)
        {
            auth()->user()->unreadNotifications->markAsRead();

            return back();
        }

        return back();
    }

}
