<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\Rotation;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use BannerSDK;

class BannerPackageFunctionTest extends TestCase
{
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

        $this->assertInstanceOf(Rotation::class, $data);
        $this->assertObjectHasAttribute('bannerUrl', $data);
        $this->assertObjectHasAttribute('bannerLink', $data);
        $this->assertObjectHasAttribute('text', $data);
        $this->assertObjectHasAttribute('phoneNumber', $data);
        $this->assertObjectHasAttribute('session', $data);
        $this->assertObjectHasAttribute('positionName', $data);
        $this->assertObjectHasAttribute('campaignName', $data);
        $this->assertObjectHasAttribute('html', $data);
        $this->assertObjectHasAttribute('isTracking', $data);
        $this->assertObjectHasAttribute('size', $data);
        $this->assertObjectHasAttribute('abTest', $data);
    }
}
