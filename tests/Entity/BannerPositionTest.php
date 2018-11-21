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
    public function testCreate()
    {
        $data = [
            'id' => 'pos_123',
            'created_at' => '2018-11-11 00:00:00',
            'updated_at' => '2018-11-11 00:00:00',
            'name' => 'test name',
            'description' => 'description',
            'width' => 100,
            'height' => 200,
            'ga_type' => 'ga_type',
            'ga_keyword' => 'ga_keyword',
            'device' => 'dumPhone',
            'view_port' => 'foo',
            'parent' => null,
            'banners' => [
                [
                    'id' => 'ban_123',
                    'created_at' => '2018-11-09 00:00:00',
                    'updated_at' => '2018-11-09 00:00:00',
                    'name' => 'foo',
                    'path' => 'path.jpg',
                    'text' => 'text',
                    'link' => 'google.de',
                    'phone_number' => '021343215',
                    'preview_url' => 'bar.com/foo.jpg'
                ]
            ]
        ];

        $pos = new BannerPosition($data);

        $this->assertEquals($data['id'], $pos->getId());

        $banners = $pos->getBanners();

        $this->assertTrue(is_array($banners));
        $this->assertInstanceOf(Banner::class, $banners[0]);
        $this->assertEquals($data['banners'][0]['id'], $banners[0]->getId());
        $this->assertInstanceOf(DateTime::class, $pos->getCreatedAt());
        $this->assertEquals($pos->getCreatedAt()->format('Y-m-d H:i:s'), $data['created_at']);
    }
}