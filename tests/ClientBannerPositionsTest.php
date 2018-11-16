<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;

use BannerSDK;

class ClientBannerPositionsTest extends TestCase
{
    public function testGetBannerPositions()
    {
        $filter = [
            'search' => 'vertical',
            'fields' => [
                'device' => 'web',
                'viewPort' => 'lg'
            ]
        ];

        $sort = [
            'name' => 'createdAt',
            'dir' => 'DESC'
        ];

        /** @var PaginatedCollection $banners */
        $banners = BannerSDK::getBannerPositions($filter, $sort);

        $this->assertInstanceOf(PaginatedCollection::class, $banners);

        foreach ($banners->getItems() as $banner) {
            $this->assertInstanceOf(BannerPosition::class, $banner);
        }
    }

    public function testBannerPositionCRUD()
    {
        $position = new BannerPosition();

        $position->setDescription('test')
            ->setName('test')
            ->setDevice('mobile')
            ->setViewPort('lg')
            ->setWidth(320)
            ->setHeight(1360);

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($position);
        $this->assertInstanceOf(BannerPosition::class, $storedPosition);

        $storedPosition->setName('EDITED BY PUT');

        /** @var BannerPosition $updatedPosition */
        $updatedPosition = BannerSDK::putBannerPosition($storedPosition);
        $this->assertEquals('EDITED BY PUT', $updatedPosition->getName());

        $this->assertTrue(BannerSDK::deleteBannerPosition($updatedPosition->getId()));
    }

    public function testBannerPositionCRUDWithoutDeviceAndViewPort()
    {
        $position = new BannerPosition();

        $position->setDescription('test')
            ->setName('test')
            ->setWidth(320)
            ->setHeight(1360);

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($position);
        $this->assertInstanceOf(BannerPosition::class, $storedPosition);

        $storedPosition->setName('EDITED BY PUT');

        /** @var BannerPosition $updatedPosition */
        $updatedPosition = BannerSDK::putBannerPosition($storedPosition);
        $this->assertEquals('EDITED BY PUT', $updatedPosition->getName());

        $this->assertTrue(BannerSDK::deleteBannerPosition($updatedPosition->getId()));
    }

    public function testPostDeleteBannersBannerPositions()
    {
        $banner = new Banner();

        $banner->setName('test')
            ->setPath('test.jpg')
            ->setLink('http://www.example.com')
            ->setPhoneNumber('0944532')
            ->setText('Test Text');

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);

        $bannerPosition = new BannerPosition();

        $bannerPosition->setDescription('test')
            ->setName('test')
            ->setDevice('mobile')
            ->setViewPort('lg')
            ->setWidth(320)
            ->setHeight(1360);

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($bannerPosition);

        $response = BannerSDK::postBannerPositionBanners(
            $storedPosition->getId(),
            [$storedBanner->getId()]
        );

        $this->assertCount(1, $response);
        $this->assertEquals($storedBanner->getId(), $response[0]['banner']);
        $this->assertEquals('ok', $response[0]['status']);
        $this->assertEmpty($response[0]['message']);

        // remove banner from banner position
        $this->assertTrue(
            BannerSDK::removeBannerFromBannerPosition(
                $storedPosition->getId(),
                $storedBanner->getId()
            )
        );

        // fetch banner from API and assert the removal
        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::getBanner($storedBanner->getId());

        $this->assertEmpty($storedBanner->getBannerPositions());

        // Delete banner and bannerPosition after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteBannerPosition($storedPosition->getId());
    }
}
