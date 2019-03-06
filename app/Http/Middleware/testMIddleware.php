<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware;

use Closure;

/**
 * Description of testMIddleware
 *
 * @author gabriel
 */
class testMIddleware {

    //put your code here
    public function handle($request, Closure $next) {

        echo"before";
        return $next($request);
    }

}
