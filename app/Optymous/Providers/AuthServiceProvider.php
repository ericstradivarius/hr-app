<?php

namespace App\Optymous\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
		'App\Optymous\File' => 'App\Optymous\Policies\FilePolicy',
		'App\Optymous\User' => 'App\Optymous\Policies\UserPolicy',
		'App\Optymous\UserType' => 'App\Optymous\Policies\UserTypePolicy',
		'App\Optymous\UserPermission' => 'App\Optymous\Policies\UserPermissionPolicy',
		'App\Optymous\campaign' => 'App\Optymous\Policies\campaignPolicy',
		'App\Optymous\candidate' => 'App\Optymous\Policies\candidatePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
		Passport::routes();

        //
    }
}
