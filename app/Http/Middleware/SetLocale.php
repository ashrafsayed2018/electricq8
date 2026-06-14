<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $segment = $request->segment(1);

        if (in_array($segment, config('app.available_locales'))) {
            app()->setLocale($segment);
            session(['locale' => $segment]);
        } else {
            app()->setLocale(session('locale', 'ar'));
        }

        return $next($request);
    }
}
