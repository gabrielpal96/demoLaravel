<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User as User;
use App\Models\Permission as Permission;
class UserPolicy {

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function user(User $user) {
        $permission = Permission::with('role')->where('name', 'user')->first();
        return $user->hasRole($permission);
    }

}
