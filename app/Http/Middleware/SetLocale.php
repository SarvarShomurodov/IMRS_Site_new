<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowed = ['uz', 'ru', 'en'];
        $locale  = session('locale');

        if (!is_string($locale) || !in_array($locale, $allowed, true)) {
            $locale = 'uz';
            $request->session()->put('locale', $locale);
        }

        \App::setLocale($locale);
        return $next($request);
    }
}
