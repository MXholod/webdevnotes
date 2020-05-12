<?php

namespace Webdev\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Webdev\Models\BlogwdCategory;
use Webdev\Models\BlogwdPost;
use Webdev\Policies\BlogwdPostPolicy;
use Webdev\Policies\BlogwdCategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'Webdev\Model' => 'Webdev\Policies\ModelPolicy',
        BlogwdCategory::class => BlogwdCategoryPolicy::class,
        BlogwdPost::class => BlogwdPostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Determine Administrator role
        Gate::define('IS_ADMIN', function ($user) {
            return $user->hasRole('Administrator');//true or false
        });
        //Moderator may view admin panel if he has permissions
        Gate::define('VIEW_ADMIN_PANEL', function ($user) {
            $is_moderator = $user->hasRole(['Administrator','Moderator']);//true or false
            $permission = $user->canDo('VIEW_ADMIN_PANEL');//true or false
            if($is_moderator && $permission){
                return true;
            }else{
                return false;
            }
        });
    }
}
