<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers as Helpers;

class PositionModel extends Model {

    protected $table = 'position';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Метода връща всичките работни позиции 
     * в масив подходящ за laravel collective select
     * @return type
     */
    public function getAllPositionArray() {
        return Helpers::FormCollectiveSelectFormat(PositionModel::all());
    }

}
