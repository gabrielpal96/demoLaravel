<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\CompanyModel as CompanyModel;
use App\Models\User as User;
use App\Models\Permission;

class CompanyPolicy {

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function company_index(User $user) {
        $permission = Permission::with('role')->where('name', 'company_index')->first();
        return $user->hasRole($permission);
    }

    public function company_edit(User $user, CompanyModel $company) {
        $permission = Permission::with('role')->where('name', 'company_edit')->first();

        return $user->hasRole($permission);
    }

    public function company_delete(User $user) {
        $permission = Permission::with('role')->where('name', 'company_delete')->first();

        return $user->hasRole($permission);
    }

}
