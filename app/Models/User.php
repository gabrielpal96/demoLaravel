<?php

/**
 * Description of User
 *
 * @author gabriel
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Storage as Storage;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Hash as Hash;
use App\Models\Role as Role;
use App\Models\Permission as Permission;
use Illuminate\Foundation\Auth\User as FoundationAuthUser;
use App\Models\CompanyModel as CompanyModel;
use App\Policies\PersonsPolicy as PersonsPolicy;

class User extends FoundationAuthUser {

    //put your code here
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    const type = array("jpeg", "jpg", "png");

    public function hasRole($permission) {
        return !!$this->role->intersect($permission->role)->count();
    }

    public function role() {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * метод, който връща всичките потребители
     * @param Request $req
     * @return type
     */
    public function getAllUsers(Request $req) {
        $query = $this
                ->leftjoin('role_user', 'users.id', '=', 'role_user.user_id')
                ->leftjoin('roles', 'role_user.role_id', '=', 'roles.id')
                ->select('users.id'
                , 'users.username'
                , 'users.active'
                , 'users.avatar'
                , 'users.email'
                , 'roles.name as role_name'
                , 'roles.id as role_id');
        if (array_key_exists("search", $req->all())) {
            foreach ($req->get('search') as $column => $searchValue) {
                $query->where('users.' . $column, 'like', '%' . $searchValue . '%');
            }
        }
        $query->orderBy('users.' . $req->input('ORDER', 'id'), 'ASC');
        return $query->paginate($req->input('list', 5));
    }

    /**
     * Метод, който намира само един потребител спрямо id
     * @param type $id
     * @return type
     */
    public function getUser($id) {
        return $this->select('users.id'
                                , 'users.username'
                                , 'users.active'
                                , 'users.avatar'
                                , 'users.email')
                        ->where('id', $id)
                        ->get();
    }

    /**
     * Метод, който сменя потребителсния статус - active/no active
     * @param type $id
     * @return boolean
     */
    public function changeStatus($id) {
        $user = $this->find($id);
        $user->active = ($user->active == 1) ? 0 : 1;
        return ($user->save()) ? true : false;
    }

    /**
     * 
     * @param type $id
     * @param type $photoName
     * @return boolean
     */
    public function savePhoto($data) {
        if (isset($data->image)) {
            if ($this->uplodePhoto($data->id, $data->image)) {
                $user = $this->find($data->id);
                $user->avatar = $data->image->getClientOriginalName();
                return ($user->save()) ? true : false;
            }
        }
    }

    /**
     * метод който връща пътя на записване на аватара
     * @param type $id
     * @return type
     */
    public function getUsarAvatarPathById($id) {
        return '/upload/user/' . $id . '/';
    }

    public function isValidType($file) {
        if (in_array($file->image->extension(), self::type)) {
            return TRUE;
        }
        return false;
    }

    /**
     * метод за качване на снимка 
     * @param type $id
     * @param type $file
     * @return boolean
     */
    public function uplodePhoto($id, $file) {
        $path = $this->getUsarAvatarPathById($id);

        if (!Storage::exists($path)) {

            if (Storage::makeDirectory($path)) {
                
            }
        }
        $path = public_path() . $this->getUsarAvatarPathById($id);

        //TO DO: kato stignesh do tuk 6te ti dam potrebitel i parola za FTP da testvame kato se smeni v config default-niq driver ot local na ftp dali 6te raboti
        if ($file->move($path, $file->getClientOriginalName())) {
            return true;
        }
    }

    /**
     * Метод, който изтрива аватара от базата от данни
     * @param type $id
     * @return boolean
     */
    public function deletePhoto($id) {

        $user = $this->find($id);
        if ($user != NULL) {
            $path = $this->getUsarAvatarPathById($id) . $user->avatar;

            if (Storage::delete($path)) {

                if ($user->avatar != NULL) {
                    $user->avatar = NULL;
                    return ($user->save()) ? TRUE : false;
                }
            }
        } else {
            
        }

        return FALSE;
    }
/*
 * 
 * testsss
 */
    /**
     * Метод, който връща името на аватара на съответния потребител спрямо id
     * @param type $id
     * @return string
     */
    public function getUserAvatar($id) {
        return $this->find($id)->avatar;
    }

    /**
     * Проверява дали това потребителско име се намирава 
     * в базата и ако го няма връща TRUE
     * @param type $username
     * @return boolean
     */
    public function checkUser($username) {
        $count = $this->select('username')
                ->where('username', $username)
                ->count();
        return($count == 0) ? TRUE : FALSE;
    }

    public function comparePassword($password, $rePassword) {
        return ($password == $rePassword) ? true : false;
    }

    /**
     * Метод за записване на нов потребител в базата от данни
     * @param type $data
     * @return boolean
     */
    public function saveUser($data) {
        unset($data['password2']);
        $data["password"] = Hash::make($data['password']);
        $user = new User();
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->email = $data['email'];

        $flag = ($user->save()) ? true : false;
        $user->role()->attach($data['role_id']);
        return $flag;
    }

    /**
     * Метод за изтриване на потребител от базата от данни
     * @param type $id
     * @return boolean
     */
    public function deleteUser($id) {
        $companyModel = new CompanyModel();
        $usar = $this->find($id);
        if ($this->deleteUserDirectory($id)) {
            $usar->role()->detach();
            if ($usar->delete()) {
                $companyModel->deleteAllCompanyByUserId($id);
                return true;
            }
        }
        return FALSE;
    }

    /**
     * Метод, който изтрива всички снимки на потребителя и собствената му директория 
     * @param type $user
     * @return boolean
     */
    public function deleteUserDirectory($id) {
        $path = $this->getUsarAvatarPathById($id);
        if (Storage::has($path)) {
            if (Storage::exists($path)) {
                if (Storage::deleteDirectory($path)) {
                    return true;
                }
            }
            return FALSE;
        }
        return true;
    }

    /**
     * Метод, който сравнява паролата от базата от данни с новата парола
     * @param type $pass
     * @return boolean
     */
    public function chackPassword($pass) {
        $user = $this->select('password')->find(Auth::user()->id);
        return Hash::check($pass, $user->password);
    }

    /**
     * Метод, който променя паролата
     * @param type $pass
     * @return boolean
     */
    public function chagePassword($data) {
        $pass = Hash::make($data->newpassword);
        return ( $this->select('password')
                        ->where('id', Auth::user()->id)
                        ->update(['password' => $pass])) ? TRUE : FALSE;
    }

    /**
     * метод, който записва на потребителя, последния език с който е бил в
     *  системата преди да излезе
     * @param type $id
     * @param type $lang
     * @return type
     */
    public function setLanguages($id, $lang) {
        return ($this->select('languages')
                        ->where('id', $id)
                        ->update(['languages' => $lang])) ? TRUE : FALSE;
    }

    public function saveRole($data) {
        $user = $this->find($data['user_id']);
        $user->role()->detach();
        $user->role()->attach($data['role_id']);
        return true;
    }

    public function permissionsSave($data) {
        $role = new Role;
        $role = $role->find($data['role_id']);
        $flag = true;
        unset($data['role_id']);

        ($role->permission()->detach());

        foreach ($data as $d) {
            $flag = ($role->permission()->attach($d)) ? TRUE : FALSE;
        }
        return $flag;
    }

    public function changeEmail($id, $email) {
        return ( $this->where('id', $id)->update(['email' => $email])) ?
                TRUE : FALSE;
    }

}
