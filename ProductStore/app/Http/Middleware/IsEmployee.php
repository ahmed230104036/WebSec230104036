<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsEmployee {
    public function handle(Request $request, Closure $next) {
        if (auth()->check() && (auth()->user()->role == 'employee' || auth()->user()->role == 'admin')) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }
}

