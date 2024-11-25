<?php

namespace Xshop\Multitenancy;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Spatie\Multitenancy\MultitenancyServiceProvider as SpatieMultitenancyServiceProvider;
use Xshop\Multitenancy\Console\Commands\CreateTenant;
use Xshop\Multitenancy\Console\Commands\ListTenants;
use Xshop\Multitenancy\Console\Commands\SetupMultitenancy;

class XshopMultitenancyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge your package configuration with Spatie's configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/multitenancy.php', 'multitenancy'
        );

        // Register the Spatie service provider to ensure its services are provided
        $this->app->register(SpatieMultitenancyServiceProvider::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Registering the command
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupMultitenancy::class,
                ListTenants::class,
                CreateTenant::class
            ]);

            $this->publishes([
                __DIR__ . '/../config/multitenancy.php' => config_path('multitenancy.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }

        // Registering routes and middleware
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', \Spatie\Multitenancy\Http\Middleware\NeedsTenant::class);
        $router->pushMiddlewareToGroup('web', \Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession::class);

        $router->middlewareGroup('tenant', [
            \Spatie\Multitenancy\Http\Middleware\NeedsTenant::class,
            \Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession::class,
        ]);
    }
}
