<?php

namespace Aboalarm\BannerManagerSdk\Test;

use Aboalarm\BannerManagerSdk\Entity\Banner;
use Aboalarm\BannerManagerSdk\Entity\Rotation;
use Aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use BannerSDK;

class BannerPackageFunctionTest extends TestCase
{
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
        $this->assertObjectHasAttribute('isCommercial', $data);
        $this->assertObjectHasAttribute('size', $data);
        $this->assertObjectHasAttribute('abTest', $data);
    }
}
