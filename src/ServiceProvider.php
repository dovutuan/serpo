<?php

namespace Dovutuan\Serpo;

use Dovutuan\Serpo\Commands\MakeRepositoryCommand;
use Dovutuan\Serpo\Commands\MakeServiceCommand;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/serpo.php', 'serpo');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/Config/serpo.php' => config_path('serpo.php')], 'serpo');

        if ($this->app->runningInConsole()) {
            $this->commands([MakeRepositoryCommand::class, MakeServiceCommand::class]);
        }
    }
}
