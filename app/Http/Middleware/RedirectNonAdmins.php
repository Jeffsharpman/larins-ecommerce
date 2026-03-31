<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectNonAdmins
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // If user is logged in but NOT admin/super_admin → redirect to homepage
            if (! $user->hasRole(['admin', 'super_admin'])) {
                return redirect('');   // or redirect()->route('home') if you have a named route
            }
        }

        return $next($request);
    }
}
