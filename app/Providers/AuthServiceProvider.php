<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
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

//        Route::group([ ‘middleware’ => ['cors','web','auth']], function() {
//
//            Passport::routes();
//
//        });

        Passport::routes();
        
//        Route::group([ ‘middleware’ => ‘cors’], function() {
//
//            Passport::routes();
//
//        });


//        Passport::tokensExpireIn(now()->addDays(15));

//        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
