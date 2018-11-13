<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use BannerSDK;

class ClientBannersTest extends TestCase
{
    public function testGetBanners()
    {
        /** @var PaginatedCollection $banners */
        $banners = BannerSDK::getBanners();

        $this->assertInstanceOf(PaginatedCollection::class, $banners);

        foreach ($banners->getItems() as $banner) {
            $this->assertInstanceOf(Banner::class, $banner);
        }
    }

    public function testBannerCRUD()
    {
        $banner = new Banner();

        $banner->setName('test')
            ->setPath('test.jpg')
            ->setLink('http://www.example.com')
            ->setPhoneNumber('0944532')
            ->setText('Test Text');

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);
        $this->assertInstanceOf(Banner::class, $storedBanner);

        $storedBanner->setName('EDITED BY PUT');

        /** @var Banner $updatedBanner */
        $updatedBanner = BannerSDK::putBanner($storedBanner);
        $this->assertEquals('EDITED BY PUT', $updatedBanner->getName());

        $this->assertTrue(BannerSDK::deleteBanner($updatedBanner->getId()));
    }
}
