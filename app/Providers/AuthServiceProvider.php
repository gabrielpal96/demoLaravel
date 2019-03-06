<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Permission as Permission;
use App\Policies\CompanyPolicy as CompanyPolicy;
use App\Models\CompanyModel as CompanyModel;
use App\Models\User as UserMidel;
use App\Policies\UserPolicy as UserPolicy;
use App\Models\PersonModel as PersonModel;
use App\Policies\PersonsPolicy as PersonsPolicy;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        CompanyModel::class => CompanyPolicy::class,
        UserMidel::class => UserPolicy::class,
        PersonModel::class => PersonsPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate) {
        $this->registerPolicies($gate);


//        $permissions = Permission::with('role')->get();
//
//        foreach ($permissions as $permission) {
//            $gate->define($permission->name, function($user) use ($permission) {
//                return $user->hasRole($permission);
//            });
//        }
    }

    protected function getPermissions() {
        return Permission::with('role')->get();
    }

}
