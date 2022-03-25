<?php

namespace Utterlabs\LaravelVite;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelViteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Registering package commands.
             $this->commands([
                 InstallCommand::class,
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        Blade::directive('vite', function (string $entrypoint) {
            return LaravelVite::assets($entrypoint)->toHtml();
        });
    }
}
