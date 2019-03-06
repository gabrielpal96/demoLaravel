<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request as Request;
use App\Models\User as userModel;
use App\Models\LanguagesModel as LanguagesModel;
use Illuminate\Support\Facades\Cache as Cache;
use Illuminate\Support\Facades\Artisan as Artisan;
use App\Http\Requests\StoreAuthRequest as StoreAuthRequest;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/company';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Предифиниран метод от класа AuthenticatesUser логин на потребител в сайта. 
     * @param Request $request
     * @param userModel $user
     * @param LanguagesModel $lang
     * @return type
     */
    public function login(Request $request, userModel $user
    , LanguagesModel $lang
    , StoreAuthRequest $storeAuthRequest) {
        if (Auth::attempt(['username' => $request->get('username')
                    , 'password' => $request->get('password')
                    , 'active' => 1])) {
            if (!Auth::guest()) {
                LanguagesModel::setLanguages(Auth::user()->languages);

                /*
                 * Изтегля от базата езиците и ги записва в кеша
                 */
                Artisan::call('cache:clear');
                Cache::store('file')->put('lang', $lang->getLanguages(), 10);
            }
            return redirect('/');
        }
        return redirect('/login');
    }

    /**
     * Предифиниран метод от класа AuthenticatesUser, за настройка 
     * потребителя да влиза в сайта не с емаил, а с потреителско име.
     * @return type
     */
    public function loginUsername() {
        return property_exists($this, 'username') ? $this->username : 'username';
    }

    /**
     * Предифиниран метод от класа AuthenticatesUser, за излизане от сайта
     *  и извикване на модела за да се запише в базата езика на сайта Ф
     * @param userModel $user
     * @return type
     */
    public function logout(userModel $user, LanguagesModel $language) {
        $user->setLanguages(Auth::user()->id, $language->getCurrentLanguage());
        Auth::guard($this->getGuard())->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ?
                $this->redirectAfterLogout : '/login');
    }

}
