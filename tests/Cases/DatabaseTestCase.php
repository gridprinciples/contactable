<?php

namespace GridPrinciples\Party\Tests\Cases;

use App\User;
use GridPrinciples\Party\Providers\PartyServiceProvider;
use Illuminate\Filesystem\ClassFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class DatabaseTestCase extends BaseTestCase
{
    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../vendor/laravel/laravel/bootstrap/app.php';

        // Register our package's service provider
        $app->register(PartyServiceProvider::class);

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    /**
     * Setup DB before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $this->migrate();
    }

    /**
     * Run package database migrations.
     * Thanks http://stackoverflow.com/questions/27759301/setting-up-integration-tests-in-a-laravel-package
     *
     * @return void
     */
    public function migrate()
    {
        $fileSystem = new Filesystem;
        $classFinder = new ClassFinder;

        $packageMigrations = $fileSystem->files(__DIR__ . "/../../src/Migrations");
        $laravelMigrations = $fileSystem->files(__DIR__ . "/../../vendor/laravel/laravel/database/migrations");

        $migrationFiles = array_merge($laravelMigrations, $packageMigrations);

        foreach ($migrationFiles as $file) {
            $fileSystem->requireOnce($file);
            $migrationClass = $classFinder->findClass($file);

            (new $migrationClass)->up();
        }
    }
}
