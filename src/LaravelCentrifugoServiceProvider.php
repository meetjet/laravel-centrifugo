<?php

declare(strict_types=1);

namespace Meetjet\LaravelCentrifugo;

use Illuminate\Broadcasting\BroadcastManager;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use GuzzleHttp\Client as HttpClient;

class LaravelCentrifugoServiceProvider extends PackageServiceProvider
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function bootingPackage()
    {
        $this->app->make(BroadcastManager::class)->extend('centrifugo', function ($app) {
            return new LaravelCentrifugoBroadcaster($app->make('centrifugo'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registeringPackage()
    {
        $this->app->singleton('centrifugo', function ($app) {
            return new LaravelCentrifugo(
                $app->make('config')->get('broadcasting.connections.centrifugo'),
                new HttpClient()
            );
        });

        $this->app->alias('centrifugo', 'Meetjet\LaravelCentrifugo\LaravelCentrifugo');
        $this->app->alias('centrifugo', 'Meetjet\LaravelCentrifugo\Contracts\LaravelCentrifugoInterface');
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-centrifugo')
            ->hasConfigFile();
    }
}
