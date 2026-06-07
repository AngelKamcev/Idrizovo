<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from URL segment or session/default
        $locale = $this->detectLocale($request);

        // Set application locale
        if (in_array($locale, ['mk', 'en', 'sq'])) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
            Cookie::queue(Cookie::make('locale', $locale, 525600));
        } else {
            app()->setLocale('mk');
            session()->put('locale', 'mk');
            Cookie::queue(Cookie::make('locale', 'mk', 525600));
        }

        return $next($request);
    }

    /**
     * Detect locale from request URL or session
     */
    protected function detectLocale(Request $request): string
    {
        // Check first segment of URL path
        $segments = $request->segments();
        if (!empty($segments) && in_array($segments[0], ['mk', 'en', 'sq'])) {
            return $segments[0];
        }

        // Check cookie
        $cookieLocale = $request->cookie('locale');
        if ($cookieLocale && in_array($cookieLocale, ['mk', 'en', 'sq'])) {
            return $cookieLocale;
        }

        // Check session
        if (session()->has('locale')) {
            return session()->get('locale');
        }

        // Default locale
        return config('app.locale', 'mk');
    }
}


