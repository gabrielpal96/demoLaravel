<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model {

    protected $table = 'country';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getCountry() {
        return $this->all();
    }

}
