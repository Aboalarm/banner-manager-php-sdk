<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use BannerSDK;

class BannerPackageFunctionTest extends TestCase
{
    /**
     * Check that the multiply method returns correct result
     * @return void
     */
    public function testGetBanners()
    {
        $banners = BannerSDK::getBanners();
        $this->assertNotEmpty($banners);
        foreach ($banners as $banner) {
            $this->assertInstanceOf(Banner::class, $banner);
        }
    }

    public function testRenderBanner()
    {
        $this->assertNotEmpty(
            BannerSDK::render('adr_438820_cancellation_right')
        );
    }

    public function testGetPositionBanner()
    {
        $data = BannerSDK::getPositionBanner('adr_438820_cancellation_right');

        $this->assertArrayHasKey('banner_url', $data);
        $this->assertArrayHasKey('text', $data);
        $this->assertArrayHasKey('phone_number', $data);
        $this->assertArrayHasKey('html', $data);
    }

    public function testRenderMultiplePositions()
    {
        $this->assertNotEmpty(
            BannerSDK::renderMultiplePositions(['adr_438820_cancellation_right'])
        );
    }

    public function testGetMultiplePositionsBanner()
    {
        $data = BannerSDK::getMultiplePositionsBanner(['adr_438820_cancellation_right']);

        $this->assertArrayHasKey('banner_url', $data);
        $this->assertArrayHasKey('text', $data);
        $this->assertArrayHasKey('phone_number', $data);
        $this->assertArrayHasKey('html', $data);
    }
}
