<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\PersonModel AS PersonModel;
use App\Models\User as User;
use App\Models\Permission as Permission;

class PersonsPolicy {

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function person_index(User $user) {
        $permission = Permission::with('role')->where('name', 'person_index')->first();
        return $user->hasRole($permission);
    }

    public function person_delete(User $user) {
        $permission = Permission::with('role')->where('name', 'person_delete')->first();
        return $user->hasRole($permission);
    }

    public function person_edit(User $user) {
        $permission = Permission::with('role')->where('name', 'person_edit')->first();
        return $user->hasRole($permission);
    }

    public function person_add(User $user) {
        $permission = Permission::with('role')->where('name', 'person_add')->first();
        return $user->hasRole($permission);
    }

}
