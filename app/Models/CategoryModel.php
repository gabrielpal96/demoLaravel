<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as Request;
use Illuminate\Database\Query\Builder;

/**
 * Description of CategoryModel
 *
 * @author gabriel
 */
class CategoryModel extends BaseModel {

    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getCategory() {
        return CategoryModel::all();
    }

}
