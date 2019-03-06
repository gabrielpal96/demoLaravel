<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use App\Models\Role;

/**
 * Description of Permission
 *
 * @author gabriel
 */
class Permission extends Model {

    public function role() {
        return $this->belongsToMany('App\Models\Role');
    }

    public function perdmissionsGrups() {
        return $this->belongsTo('App\Models\PermissionsGrups');
    }

}
