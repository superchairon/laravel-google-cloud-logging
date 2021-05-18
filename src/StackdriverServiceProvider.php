<?php

namespace SuperChairon\LaravelGoogleCloudLogging;

use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;

class StackdriverServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
        if (($logManager = $this->app->make('log')) instanceof LogManager) {
            $logManager->extend('stackdriver', function ($app, array $config) {
                return (new StackdriverChannel($app))($config);
            });
        }
    }
}
