<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Role as Role;

class AdminController extends Controller {

    public function index() {
        var_dump(111111111111111111111111111);
        echo '=<br>';
        die;
    }

    public function newRole(Request $req, Role $role) {
        return $role->saveRole($req->get('role')) ? "Успешно записахте новата роля" : 'Нещо се обърка. Опитай пак.';
    }

}
