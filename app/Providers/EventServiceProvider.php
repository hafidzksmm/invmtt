<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \Illuminate\Auth\Events\Login::class => [
            [\App\Listeners\LogAuthActivity::class, 'handleLogin'],
        ],

        \Illuminate\Auth\Events\Logout::class => [
            [\App\Listeners\LogAuthActivity::class, 'handleLogout'],
        ],
    ];

    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}