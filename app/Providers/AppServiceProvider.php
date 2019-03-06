<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\LanguagesModel as LanguagesModel;
use Illuminate\Support\Facades\Cache as Cache;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(LanguagesModel $lang) {

        /**
         * закача за всяко view езиците изкарани от базата
         */
        view()->share(LanguagesModel::lang, LanguagesModel::getLanguagesInCache());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
