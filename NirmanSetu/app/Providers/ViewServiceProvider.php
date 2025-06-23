<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $unreadCount = 0;
            $notifications = collect();

            if (Auth::check()) {
                $unreadCount = Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                $notifications = Notification::where('user_id', Auth::id())->latest()->take(5)->get();
            }

            $view->with('unreadCount', $unreadCount)->with('notifications', $notifications);
        });
    }

    public function register()
    {
        //
    }
}