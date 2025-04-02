<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        date_default_timezone_set('UTC');
        $locale = $request->session()->get('Lang');
        if ($locale !== null && in_array($locale, config('app.locales'))) {
            App::setLocale($locale);
        }
        if ($locale === null) {
            $request->session()->put('Lang',config('app.locale'));
        }
        return $next($request);
    }
}
