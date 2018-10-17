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
            BannerSDK::render('adr_436928_top_horizotal', 'session')
        );
    }

    public function testGetPositionBanner()
    {
        $data = BannerSDK::getPositionBanner('adr_436928_top_horizotal', 'session');

        print_r($data);
        $this->assertArrayHasKey('banner_url', $data);
        $this->assertArrayHasKey('text', $data);
        $this->assertArrayHasKey('phone_number', $data);
        $this->assertArrayHasKey('html', $data);
    }
}
