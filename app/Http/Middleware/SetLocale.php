<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Resolve and set the app locale for the current request.
     *
     * Public site routes are duplicated per language (unprefixed = Arabic,
     * "/en/..." = English), so the URL itself is the only source of truth —
     * falling back to a remembered session locale would let a stale
     * preference override an explicit, unprefixed Arabic URL (this happened
     * in practice: /areas/{arabic-slug} was redirecting to the English page
     * for visitors/crawlers whose session still had locale=en from an
     * earlier request). Only routes with no per-language duplicate (admin
     * panel, login/logout — pass "session" as the middleware argument) may
     * use the remembered session preference, since there they truly have no
     * URL signal to go on.
     */
    public function handle(Request $request, Closure $next, string $fallback = 'url'): Response
    {
        $segment = $request->segment(1);

        if (in_array($segment, config('app.available_locales'))) {
            app()->setLocale($segment);
            session(['locale' => $segment]);
        } elseif ($fallback === 'session') {
            app()->setLocale(session('locale', 'ar'));
        } else {
            app()->setLocale('ar');
        }

        return $next($request);
    }
}
