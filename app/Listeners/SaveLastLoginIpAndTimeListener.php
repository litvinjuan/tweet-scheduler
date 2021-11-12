<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class SaveLastLoginIpAndTimeListener
{
    public function handle(Login $event)
    {
        $event->user->update([
            'last_login_ip' => request()->ip(),
            'last_login_at' => now(),
        ]);
    }
}
