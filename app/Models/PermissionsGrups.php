<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Description of PermissionsGrups
 *
 * @author gabriel
 */
class PermissionsGrups extends Model {

    public function permission() {
        return $this->belongsTo('App\Models\Permission');
    }

}
