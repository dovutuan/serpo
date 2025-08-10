<?php

namespace Dovutuan\Serpo;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/serpo.php', 'serpo');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/Config/serpo.php' => config_path('serpo.php')], 'serpo');
    }


//    /**
//     * Bootstrap any application services.
//     */
//    public function boot()
//    {
//        // publishes file config
//        $this->publishes(
//            [
//                __DIR__ . '/DomRepository/config/laracom.php' => config_path('laracom.php')
//            ],
//            'laracom');
//
//        // create file config
//        $configPath = __DIR__ . '/DomRepository/config/laracom.php';
//        $this->mergeConfigFrom($configPath, 'laracom');
//
//        if ($this->app->runningInConsole()) {
//            $this->commands([MakeServiceCommand::class, MakeRepositoryCommand::class]);
//        }
//    }
}
