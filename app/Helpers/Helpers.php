<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helpers
 *
 * @author gabriel
 */

namespace App\Helpers;

class Helpers {

    public static function FormCollectiveSelectFormat($data) {
        $tmp = [];
        foreach ($data->toArray() as $p) {
            $tmp[$p['id']] = $p['name'];
        }
        return $tmp;
    }

}
