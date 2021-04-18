<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;
use App\User;
use App\PermissionUser;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach($this->lista() as $key => $permission){
            
            Gate::define($permission->name, function (User $user) use($permission) {
                return $user->hasPermissions($permission->users);
            });
        }

    }

    public function lista()
    {
        return Permission::with('users')->get();
    }
}
