<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 10/2/18
 * Time: 11:37 AM
 */

namespace evis\BannerManager\Test;

use evis\BannerManager\Laravel\Facade;
use evis\BannerManager\Laravel\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'BannerSDK' => Facade::class,
        ];
    }
}