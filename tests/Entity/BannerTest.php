<?php

namespace Aboalarm\BannerManagerSdk\Test\Entity;

use Aboalarm\BannerManagerSdk\Entity\Banner;
use Aboalarm\BannerManagerSdk\Entity\BannerPosition;
use Aboalarm\BannerManagerSdk\Entity\Campaign;
use Aboalarm\BannerManagerSdk\Test\TestCase;
use DateTime;

/**
 * Class BannerPositionTest
 * @package Aboalarm\BannerManagerSdk\Test\Entity
 */
class BannerTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        $data = $this->getBannerMock('ban_1234');
        $data['banner_positions'] = [
            $this->getPositionMock()
        ];

        $data['campaigns'] = [
            $this->getCampaignMock()
        ];

        $banner = new Banner($data);

        $this->assertEquals($data['id'], $banner->getId());

        $positions = $banner->getBannerPositions();
        $campaigns = $banner->getCampaigns();

        $this->assertTrue(is_array($positions));
        $this->assertInstanceOf(BannerPosition::class, $positions[0]);
        $this->assertEquals($data['banner_positions'][0]['id'], $positions[0]->getId());
        $this->assertInstanceOf(DateTime::class, $banner->getCreatedAt());
        $this->assertEquals($banner->getCreatedAt()->format('Y-m-d H:i:s'), $data['created_at']);

        $this->assertTrue(is_array($campaigns));
        $this->assertInstanceOf(Campaign::class, $campaigns[0]);
        $this->assertEquals($data['campaigns'][0]['id'], $campaigns[0]->getId());

        $this->assertEquals($data['orientation'], $banner->getOrientation());
    }
}
