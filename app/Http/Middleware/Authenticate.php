<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if (Auth::guard('web')->check()) {
            Auth::shouldUse('web');
            return;
        }

        if (Auth::guard('admin')->check()) {
            Auth::shouldUse('admin');
            return;
        }

        $this->unauthenticated($request, ['web', 'admin']);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return '/auth';
        }
    }
}
