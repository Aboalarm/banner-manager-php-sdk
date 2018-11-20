<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use BannerSDK;

class BannerPackageFunctionTest extends TestCase
{
    public function testRenderBanner()
    {
        $this->assertNotEmpty(
            BannerSDK::render('adr_438820_web_cancellation_vertical_right')
        );
    }

    public function testGetPositionBanner()
    {
        $data = BannerSDK::getPositionBanner('adr_438820_web_cancellation_vertical_right');

        $this->assertArrayHasKey('banner_url', $data);
        $this->assertArrayHasKey('text', $data);
        $this->assertArrayHasKey('phone_number', $data);
        $this->assertArrayHasKey('html', $data);
    }

    public function testRenderMultiplePositions()
    {
        $this->assertNotEmpty(
            BannerSDK::renderMultiplePositions(['adr_438820_web_cancellation_vertical_right'])
        );
    }

    public function testGetMultiplePositionsBanner()
    {
        $data = BannerSDK::getMultiplePositionsBanner(['adr_438820_web_cancellation_vertical_right']);

        $this->assertArrayHasKey('banner_url', $data);
        $this->assertArrayHasKey('text', $data);
        $this->assertArrayHasKey('phone_number', $data);
        $this->assertArrayHasKey('html', $data);
    }
}
