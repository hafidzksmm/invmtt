<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogAuthActivity
{
    public function handleLogin(Login $event)
    {
        ActivityLog::create([
            'user_id'     => $event->user->id,
            'user_name'   => $event->user->name,
            'user_role'   => $event->user->role ?? null,
            'action'      => 'login',
            'model_type'  => null,
            'model_id'    => null,
            'description' => "{$event->user->name} login ke sistem",
            'old_values'  => null,
            'new_values'  => null,
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);
    }

    public function handleLogout(Logout $event)
    {
        if (!$event->user) {
            return;
        }

        ActivityLog::create([
            'user_id'     => $event->user->id,
            'user_name'   => $event->user->name,
            'user_role'   => $event->user->role ?? null,
            'action'      => 'logout',
            'model_type'  => null,
            'model_id'    => null,
            'description' => "{$event->user->name} logout dari sistem",
            'old_values'  => null,
            'new_values'  => null,
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);
    }
}