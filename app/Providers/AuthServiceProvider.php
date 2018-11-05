<?php

namespace App\Providers;

use App\Entities\Page;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Gate::define('seller-only', function ($user) {
            $ifSeller=Page::where('fb_id', $user->fb_id)->count();
            if($ifSeller>0)
            {
                return true;
            }
            return false;
        });
    }
}
