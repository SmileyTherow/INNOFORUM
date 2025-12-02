<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        // Kirim notifikasi global ke semua view (bisa diakses dengan $global_notifications)
        View::composer('*', function ($view) {
            $user = Auth::user();
            $notifications = collect();
            if ($user) {
                $notifications = Notification::where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->take(10)
                    ->get();
            }
            $view->with('global_notifications', $notifications);
        });
    }
}
