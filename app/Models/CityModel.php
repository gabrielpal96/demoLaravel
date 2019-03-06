<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Description of CityModel
 *
 * @author gabriel
 */
class CityModel extends Model {

    protected $table = 'city';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getCity() {
        return $this->all();
    }

    public function getCityByCountryId($country_id) {
        return $this->select('id', 'name')->where('country_id', $country_id)->get();
    }

}
