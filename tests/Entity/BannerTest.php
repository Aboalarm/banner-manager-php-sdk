<?php

namespace aboalarm\BannerManagerSdk\Test\Entity;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Test\TestCase;
use DateTime;

/**
 * Class BannerPositionTest
 * @package aboalarm\BannerManagerSdk\Test\Entity
 */
class BannerTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        $data = $this->getBannerMock('ban_1234', '160', '600');
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

        $this->assertEquals('vertical', $banner->getBannerOrientation());

        $bannerHorizontal = new Banner($this->getBannerMock('ban_1234', '600', '160'));
        $this->assertEquals('horizontal', $bannerHorizontal->getBannerOrientation());

        $bannerSquare = new Banner($this->getBannerMock('ban_1234', '300', '300'));
        $this->assertEquals('square', $bannerSquare->getBannerOrientation());

        $bannerIncorrect = new Banner($this->getBannerMock('ban_1234', '0', '160'));
        $this->assertEquals('incorrect dimensions', $bannerIncorrect->getBannerOrientation());
    }
}
