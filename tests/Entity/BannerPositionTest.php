<?php

namespace aboalarm\BannerManagerSdk\Test\Entity;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Test\TestCase;
use DateTime;

/**
 * Class BannerPositionTest
 * @package aboalarm\BannerManagerSdk\Test\Entity
 */
class BannerPositionTest extends TestCase
{
    public function testCreateWithParent()
    {
        $data = $this->getPositionMock();
        $data['banners'] = [
            $this->getBannerMock()
        ];
        $data['parent'] = $this->getPositionMock('pos_222');

        $pos = new BannerPosition($data);

        $this->assertEquals($data['id'], $pos->getId());

        $banners = $pos->getBanners();

        $this->assertTrue(is_array($banners));
        $this->assertInstanceOf(Banner::class, $banners[0]);
        $this->assertEquals($data['banners'][0]['id'], $banners[0]->getId());
        $this->assertInstanceOf(DateTime::class, $pos->getCreatedAt());
        $this->assertEquals($pos->getCreatedAt()->format('Y-m-d H:i:s'), $data['created_at']);
        $this->assertInstanceOf(BannerPosition::class, $pos->getParent());
        $this->assertEquals('pos_222', $pos->getParent()->getId());
    }

    public function testCreateWithChildren()
    {
        $data = $this->getPositionMock();
        $data['children'] = [
            $this->getPositionMock('pos_222')
        ];

        $pos = new BannerPosition($data);
        $children = $pos->getChildren();

        $this->assertEquals($data['id'], $pos->getId());

        $this->assertNull($pos->getParent());
        $this->assertTrue(is_array($children));

        $this->assertInstanceOf(BannerPosition::class, $children[0]);
        $this->assertEquals('pos_222', $children[0]->getId());
    }
}
