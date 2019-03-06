<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Lang as Lang;
use App\Models\LanguagesModel as LanguagesModel;

class Languages {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        Lang::setLocale(LanguagesModel::getCurrentLanguage());

        return $next($request);
    }

}
