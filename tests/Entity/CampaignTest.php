<?php


namespace Aboalarm\BannerManagerSdk\Test\Entity;

use Aboalarm\BannerManagerSdk\Entity\ABTest;
use Aboalarm\BannerManagerSdk\Entity\Banner;
use Aboalarm\BannerManagerSdk\Entity\Campaign;
use Aboalarm\BannerManagerSdk\Entity\Timing;
use Aboalarm\BannerManagerSdk\Test\TestCase;

/**
 * Class CampaignTest
 * @package Aboalarm\BannerManagerSdk\Test\Entity
 */
class CampaignTest extends TestCase
{
    public function testCreate()
    {
        $data = $this->getCampaignMock();

        $data['banners'] = [
            $this->getBannerMock()
        ];

        $data['campaign_timings'] = [
            $this->getTimingMock()
        ];

        $data['ab_test'] = $this->getABTestMock();

        $campaign = new Campaign($data);

        $this->assertTrue(is_array($campaign->getBanners()));
        $this->assertTrue(is_array($campaign->getTimings()));

        $this->assertInstanceOf(ABTest::class, $campaign->getAbTest());
        $this->assertInstanceOf(Banner::class, $campaign->getBanners()[0]);
        $this->assertInstanceOf(Timing::class, $campaign->getTimings()[0]);
        $this->assertEquals($campaign->getCreatedAt()->format('Y-m-d H:i:s'), $data['created_at']);
        $this->assertEquals($campaign->getUpdatedAt()->format('Y-m-d H:i:s'), $data['updated_at']);
        $this->assertEquals($data['name'], $campaign->getName());
        $this->assertEquals($data['description'], $campaign->getDescription());
        $this->assertEquals($data['weight'], $campaign->getWeight());
        $this->assertEquals($data['app_mobile_always_hotline'], $campaign->isAppMobileAlwaysHotline());
        $this->assertEquals($data['tracking_disabled'], $campaign->isTrackingDisabled());
    }
}
