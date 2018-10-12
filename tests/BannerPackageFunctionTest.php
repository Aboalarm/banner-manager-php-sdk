<?php

namespace aboalarm\BannerManagerSdk\Test;

use BannerSDK;

class BannerPackageFunctionTest extends TestCase
{
    /**
     * Check that the multiply method returns correct result
     * @return void
     */
    public function testGetBanners()
    {
        $this->assertNotEmpty(BannerSDK::getBanners());
    }

    public function testRenderBanner()
    {
        $this->assertNotEmpty(
            BannerSDK::render('adr_1235_top_horizotal', 'session', 'test_device')
        );
    }
}
