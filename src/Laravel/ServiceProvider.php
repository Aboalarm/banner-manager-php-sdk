<?php

namespace aboalarm\BannerManagerSdk\Laravel;

use aboalarm\BannerManagerSdk\BannerSDK\Client;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__.'/config/config.php' => config_path('banner.php'),
            ],
            'bannersdk'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'banner');

        $this->app->singleton(
            'aboalarm.bannersdk',
            function ($app) {
                return new Client(
                    config()->get('banner.base_uri'),
                    config()->get('banner.username'),
                    config()->get('banner.password'),
                    config()->get('banner.reports_path'),
                    config()->get('banner.proxy_uri')
                );
            }
        );

        $this->app->bind('aboalarm\BannerManagerSdk\BannerSDK\Client', 'aboalarm.bannersdk');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aboalarm.bannersdk'];
    }
}
