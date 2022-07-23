<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * @param  Request  $request
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale(is_array($locale) ? $locale[0] : $locale);
        } else {
            $availableLanguages = config('app.available_locales');
            $userLanguages = preg_split('/[,;]/', $request->server('HTTP_ACCEPT_LANGUAGE'));

            foreach ($userLanguages as $language) {
                if (in_array($language, $availableLanguages, true)) {
                    App::setLocale($language);
                    Session::push('locale', $language);
                    break;
                }
            }
        }

        return $next($request);
    }
}
