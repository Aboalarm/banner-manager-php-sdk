<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\ABTest;
use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Entity\Timing;
use aboalarm\BannerManagerSdk\Laravel\Facade;
use aboalarm\BannerManagerSdk\Laravel\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * Load package alias
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'BannerSDK' => Facade::class,
        ];
    }

    /**
     * Create a new banner
     *
     * @return Banner
     */
    public function createBanner()
    {
        $banner = new Banner();

        $banner->setName(TestConstants::BANNER_NAME)
            ->setDescription(TestConstants::BANNER_DESCRIPTION)
            ->setPath(TestConstants::BANNER_IMAGE)
            ->setLink(TestConstants::BANNER_LINK)
            ->setPhoneNumber(TestConstants::BANNER_PHONE)
            ->setText(TestConstants::BANNER_TEXT)
            ->setApproved(true);

        return $banner;
    }

    /**
     * Create a banner that will cause validation errors
     *
     * @return Banner
     */
    public function createInvalidBanner() {
        $banner = new Banner();

        $banner->setLink(TestConstants::BANNER_INVALID_LINK);

        return $banner;
    }

    /**
     * Create a new Campaign
     *
     * @return Campaign
     */
    public function createCampaign()
    {
        $campaign = new Campaign();

        $campaign->setWeight(TestConstants::CAMPAIGN_WEIGHT)
            ->setDescription(TestConstants::CAMPAIGN_DESCRIPTION)
            ->setName(TestConstants::CAMPAIGN_NAME);

        return $campaign;
    }

    /**
     * Create a new Banner position
     * @return BannerPosition
     */
    public function createBannerPosition()
    {
        $bannerPosition = new BannerPosition();

        $bannerPosition->setName(TestConstants::BANNER_POSITION)
            ->setDescription(TestConstants::BANNER_POSITION_DESCRIPTION)
            ->setDevice(TestConstants::BANNER_POSITION_DEVICE)
            ->setViewPort(TestConstants::BANNER_POSITION_VIEW_PORT)
            ->setWidth(TestConstants::BANNER_POSITION_WIDTH)
            ->setHeight(TestConstants::BANNER_POSITION_HEIGHT)
            ->setGaKeyword(TestConstants::BANNER_POSITION_GA_KEYWORD)
            ->setGaType(TestConstants::BANNER_POSITION_GA_TYPE);

        return $bannerPosition;
    }

    /**
     * Create new ABTest
     *
     * @return ABTest
     */
    public function createABTest()
    {
        $abtest = new ABTest();

        $abtest->setDescription('test')
            ->setName('test');

        return $abtest;
    }

    /**
     * Create new Timing
     *
     * @return Timing
     */
    public function createTiming()
    {
        $timing = new Timing();
        $timing->setType(Timing::TYPE_WORKDAYS)
            ->setTimeFrom(TestConstants::CAMPAIGN_TIMING_TIME_FROM)
            ->setTimeUntil(TestConstants::CAMPAIGN_TIMING_TIME_UNTIL);

        return $timing;
    }
}
