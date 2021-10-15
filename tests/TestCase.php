<?php

namespace Meetjet\LaravelCentrifugo\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Meetjet\LaravelCentrifugo\LaravelCentrifugoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Meetjet\\LaravelCentrifugo\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelCentrifugoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-centrifugo_table.php.stub';
        $migration->up();
        */
    }
}
