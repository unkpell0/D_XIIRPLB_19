<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class SubDomainSession
{
    // public function handle($request, Closure $next)
    // {
    //     $host = $request->getHost();
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()->route('login');
    //     }

    //     if ($host === 'admin.localhost' && $user->type !== 'admin') {
    //         Auth::logout();
    //         return redirect()->route('login')->withErrors('Unauthorized access');
    //     }

    //     if ($host === 'user.localhost' && $user->type !== 'user') {
    //         Auth::logout();
    //         return redirect()->route('login')->withErrors('Unauthorized access');
    //     }

    //     return $next($request);
    // }
}
