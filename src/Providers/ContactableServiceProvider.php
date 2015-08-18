<?php

namespace GridPrinciples\Contactable\Providers;

use GridPrinciples\Contactable\Providers\ContactableAuthProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ContactableServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/contactable.php', 'contactable'
        );
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../../config/contactable.php' => config_path('contactable.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../Migrations/' => database_path('migrations')
        ], 'migrations');

        app()->bind('ContactableAuthProvider', function () {
            return new ContactableAuthProvider(app('hash'), config('auth.model', \App\User::class));
        });

        // Add authentication driver
        Auth::extend('contactable', function($app) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return $app->make('ContactableAuthProvider');
        });
    }
}
