<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', App::currentLocale());

        $requestLocale = $request->segment(1);

        if (in_array($requestLocale, config('app.available_locales'), true)) {
            $locale = $requestLocale;
        } else {
            return redirect($locale);
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);
        Session::put('locale', $locale);

        return $next($request);
    }
}
