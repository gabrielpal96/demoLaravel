<?php

//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use App\Http\Requests;
//use Illuminate\Support\Facades\App as App;
//
//class LanguagesController extends Controller {
//
//    const lang = 'lang';
//
//    public static function setLanguages($lang) {
//        if (session()->has(self::lang)) {
//            session()->put(self::lang, $lang);
//        } else {
//            session([self::lang => App::getLocale()]);
//        }
//    }
//
//    public static function getLanguages() {
//        self::setDefaultLanguages();
//        return session(self::lang);
//    }
//
//    private static function setDefaultLanguages() {
//
//        if (!session()->has(self::lang)) {
//            session()->put(self::lang, App::getLocale());
//        }
//    }
//
//}
