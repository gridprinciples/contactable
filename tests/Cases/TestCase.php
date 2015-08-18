<?php

namespace GridPrinciples\Contactable\Tests\Cases;

use GridPrinciples\Contactable\Providers\ContactableServiceProvider;
use GridPrinciples\Contactable\Tests\Mocks\ContactableAuthProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../vendor/laravel/laravel/bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        // Register our package's service provider
        $app->register(ContactableServiceProvider::class);

        // Bind the auth implementation with a mocked one so we may inject the mock User class
//        $app->bind('ContactableAuthProvider', function ($app) {
//            return new \GridPrinciples\Contactable\Tests\Mocks\ContactableAuthProvider(app('hash'), '\App\User');
//        });

        // Set app configuration
        config([
            'auth.driver' => 'contactable',
            'auth.model' => \GridPrinciples\Contactable\Tests\Mocks\User::class,
        ]);

        return $app;
    }
}
