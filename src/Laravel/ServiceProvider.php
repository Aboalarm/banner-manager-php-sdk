<?php

namespace evis\BannerManager\Laravel;

use evis\BannerManager\BannerSDK\Client;


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
            'evis.banner',
            function ($app) {
                return new Client(
                    config()->get('banner.base_uri'),
                    config()->get('banner.username'),
                    config()->get('banner.password')
                );
            }
        );

        $this->app->bind('evis\BannerManager\BannerSDK\Client', 'evis.banner');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['evis.banner'];
    }
}
