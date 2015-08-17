<?php

namespace GridPrinciples\Party\Providers;

use GridPrinciples\Party\Providers\ContactableAuthProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class PartyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::extend('contactable', function() {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new ContactableAuthProvider(new BcryptHasher(), '\App\User');
        });
    }
}
