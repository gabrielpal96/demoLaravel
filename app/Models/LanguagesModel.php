<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache as Cache;
use Illuminate\Support\Facades\App as App;
class LanguagesModel extends Model {

    protected $table = 'languages';
    protected $primaryKey = 'id';
    public $timestamps = false;

    const active = 1;
    const lang = 'lang';
    const file = 'file';

    /**
     * метод, който връща всичките езици от базата
     * @return type
     */
    public static function getLanguages() {
        return LanguagesModel::where('active', self::active)->get();
    }

    public static function setLanguages($lang) {
        if (session()->has(self::lang)) {
            session()->put(self::lang, $lang);
        } else {
            session([self::lang => App::getLocale()]);
        }
    }

    public static function getCurrentLanguage() {
        self::setDefaultLanguages();
        return session()->get(self::lang);
    }

    private static function setDefaultLanguages() {

        if (!session()->has(self::lang)) {
            session()->put(self::lang, App::getLocale());
        }
    }

    public static function setLanguagesInCache($languages) {
        if (!Cache::has(self::lang)) {
            Cache::store(self::file)->put(self::lang, $languages, 10);
        }
    }

    public static function getLanguagesInCache() {
        self::setLanguagesInCache(self::getLanguages());
        return Cache::store(self::file)->get(self::lang);
    }

}
