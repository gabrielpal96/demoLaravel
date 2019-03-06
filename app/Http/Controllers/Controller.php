<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request as Request;
use App\Models\LanguagesModel as LanguagesModel;

class Controller extends BaseController {

    use AuthorizesRequests,
        AuthorizesResources,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * метод за добавяне на флаш съобщения
     * @param type $message
     * @param type $alert
     */
    public static function flashMessage($messageCode, $alert = 'success') {
//        if (Session::has('message')) {
//            $tmp = Session::get('message');
//            $message .=' '.$tmp;
//        }


        Session::flash('message', trans($messageCode));
        Session::flash('alert-class', 'alert-' . $alert);
    }

    public static function flashMessageNoTranslate($message, $alert = 'success') {
        Session::flash('message', $message);
        Session::flash('alert-class', 'alert-' . $alert);
    }

    public function languages($lang) {
        LanguagesModel::setLanguages($lang);
        return redirect()->back();
    }

    public function appends(Request $req, $data) {
        $data->appends(['list' => $req->input('list', 5)]);
        $data->appends(['ORDER' => $req->input('ORDER', 'id')]);
        $data->appends(['page' => $req->input('page', 2)]);
//        return $data;
    }

}
