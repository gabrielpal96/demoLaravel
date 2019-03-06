<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request as Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User as User;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\Role as Role;
use App\Models\Permission as Permission;
use App\Http\Requests\StoreUserRequest as StoreUserRequest;

class UserController extends Controller {

    /**
     *
     * @var type 
     * 
     */
    private $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    /**
     * метод, който извиква view за изпечатване на всички потребители
     * @param Request $req
     * @return type
     */
    public function index(Request $req, Role $role) {
        $this->authorize('user', User::class);

        $users = $this->userModel->getAllUsers($req);
        $this->appends($req, $users);
        return view('User.index', [
            'user' => $users, 'role' => $role->all()->toArray()
        ]);
    }

    /**
     * Метод, който сменя статуса на потребителя-active/no active
     * @param type $id
     * @return type
     */
    public function changeStatus($id) {
        $this->authorize('user', User::class);
        if ($this->userModel->changeStatus($id)) {
            $this->flashMessage('message/users.userChageStatusSuccess');
        } else {
            $this->flashMessage('message/users.userChageStatusDanger', 'danger');
        }
        return redirect('user');
    }

    public function addPhoto($id) {
        if ($id != Auth::user()->id) {
            $this->authorize('user', User::class);
        }
        return view('User.addPhoto', ['id' => $id,
            'user' => $this->userModel->getUser($id)]);
    }

    /**
     * Метод за добавяне на снимки на потребител 
     * @param Request $req
     * @return type
     */
    public function upload(Request $req) {

        if (isset($req->image)) {
            if (!$this->userModel->isValidType($req)) {
                Controller::flashMessageNoTranslate('message/users.isNotValidType', "danger");
                return redirect()->back();
            }
            if ($this->userModel->savePhoto($req)) {
                $this->flashMessage('message/users.uplodePhotoSuccess');
                return redirect()->back();
            } else {
                return redirect()->route("addPhoto", $req->id);
            }
        }
    }

    /**
     * Метод за изтриване на всички снимки на потребителя
     * @param type $id
     * @return boolean
     */
    public function photoDelete($id) {
        if ($id != Auth::user()->id) {
            $this->authorize('user', User::class);
        }

        if ($this->userModel->deletePhoto($id)) {
            $this->flashMessage('message/users.deletePhotoSuccess');
        } else {
            $this->flashMessage('message/users.deletePhotoDanger', 'danger');
        }
        return redirect()->back();
    }

    /**
     *  метод, който извиква view за добавяне на нов потребител
     * @return type
     */
    public function newUser(Role $role) {
        $this->authorize('user', User::class);
        return view('User.newUser', ['role' => $role->all()]);
    }

    /**
     * Метод, който записва нов потребител
     * @param Request $req
     * @return type
     */
    public function saveUser(Request $req, StoreUserRequest $storeUserRequest) {
        $this->authorize('user', User::class);
        $data = $req->all();

        //TO DO: опитай да премахнеш някой от IF-овете
        if ($this->userModel->checkUser($req->username)) {
            if ($this->userModel->comparePassword($req->password, $req->password2)) {
                if ($this->userModel->saveUser($data)) {
                    $this->flashMessage('message/users.userRegisterSuccess');
                    return redirect()->route("user");
                } else {
                    $this->flashMessage('message/users.userRegisterDanger', 'danger');
                }
            } else {
                Controller::flashMessage('message/users.passwordDanger', 'danger');
            }
        } else {
            $this->flashMessage('message/users.usernameExists', 'danger');
        }

        return redirect()->route("newUser");
    }

    /**
     * Метод, който изтрива един потребител и неговите снимки
     * @param type $id
     */
    public function deleteUser($id) {
        $this->authorize('user', User::class);
        if ($this->userModel->deleteUser($id)) {
            $this->flashMessage('message/users.userDeleteSuccess');
        } else {
            $this->flashMessage('message/users.userDeleteDanger', 'danger');
        }
        return redirect('/user');
    }

    /**
     *  метод, който извиква view за профила на потребителя
     * @return type
     */
    public function profile() {

        return view('User.Profile.profile');
    }

    /**
     * Метод, който сменя паролата на потребителя
     * @param Request $req
     * @return type
     */
    public function chagePassword(Request $req) {


        if (!empty($req->all())) {

            if ($req->newpassword == $req->newpassword2
                    AND $this->userModel->chackPassword($req->oldpassword)) {
                if ($this->userModel->chagePassword($req)) {
                    $this->flashMessage('message/users.chagePasswordSuccess');
                }
            } else {
                $this->flashMessage('message/users.chagePasswordDanger', 'warning');
            }
            return redirect()->route("profile");
        }

        return view('User.Profile.chagePassword');
    }

    public function saveRole(Request $req) {
        if ($req->role_id != null) {
            if ($this->userModel->saveRole($req->all())) {

                Controller::flashMessage('message/users.chageRoleSuccess');
            }
        }

        $return = json_encode(['alert' => session()->get('alert-class'), 'message' => session()->get('message')]);
        session()->forget('message');
        return $return;
    }

    public function permissions(Permission $permission, Role $role) {
        $this->authorize('user', User::class);
//        echo"<pre>";
//        print_r($role::with('permission')->get()->toArray());
//        echo"</pre>";
        $grups = \App\Models\PermissionsGrups::all()->toArray();
        $role = $role::with('permission')->get()->toArray();


        return view('User.permissions', ['permissions' =>
            $permission->all()->toArray(), 'roles' => $role, 'grups' => $grups]);
    }

    public function permissionsAction(Request $req) {
        $this->authorize('user', User::class);
        unset($req['_token']);
        if ($this->userModel->permissionsSave($req->all())) {
            
        }
        return redirect()->route("permissions");
    }

    public function changeEmail(Request $req) {
        $this->validate($req, [
            'email' => 'email'
        ]);
        if (Auth::user()->role->toArray()[0]['id'] == 1 || $req->get('id') == Auth::user()->id) {
            return ($this->userModel->changeEmail($req->get('id')
                            , $req->get('email'))) ?
                response()->json(['email' => $req->get('email'),'alert' => 'alert-success', 'message' => "uspeshno smenihte emaila"])
                : FALSE;
        } else {
            return $this->flashMessage('message/users.changeEmailDanger', 'danger');
        }
    }

    public function getEmail() {
//        return Auth::user()->email;
        return response()
                        ->json(['email' => Auth::user()->email]);
    }

}
