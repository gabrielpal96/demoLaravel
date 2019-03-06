<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use App\Models\Permission as Permission;

/**
 * Description of Role
 *
 * @author gabriel
 */
class Role extends Model {

    public function permission() {
        return $this->belongsToMany('App\Models\Permission');
    }

    public function perdmissionsGrups() {
        return $this->hasMany('App\Models\PermissionsGrups');
    }

    public function saveRole($data) {
        $role = new Role;
        $role->name = $data;
        return($role->saveOrFail()) ? TRUE : FALSE;
    }

//    public function givePermissionTo(Permission $permission) {
//        return $this->permissions()->save($permission);
//    }
}
