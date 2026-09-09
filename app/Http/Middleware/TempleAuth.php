<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TempleAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('temple_logged_in')) {
            return redirect('/')
                ->with('error', 'Please login first.');
        }

        return $next($request);
    }
}