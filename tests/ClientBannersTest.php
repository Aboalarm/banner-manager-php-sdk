<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\Campaign;
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

    public function testPostDeleteCampaignBanners()
    {
        $campaign = new Campaign();

        $campaign->setWeight(1)
            ->setDescription('test')
            ->setName('test');

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);

        $banner = new Banner();

        $banner->setName('test')
            ->setPath('test.jpg')
            ->setLink('http://www.example.com')
            ->setPhoneNumber('0944532')
            ->setText('Test Text');

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);

        $response = BannerSDK::postBannerCampaigns(
            $storedBanner->getId(),
            [$storedCampaign->getId()]
        );

        $this->assertCount(1, $response);
        $this->assertEquals($storedCampaign->getId(), $response[0]['campaign']);
        $this->assertEquals('ok', $response[0]['status']);
        $this->assertEmpty($response[0]['message']);

        // remove campaign from banner
        $this->assertTrue(
            BannerSDK::removeCampaignFromBanner($storedBanner->getId(), $storedCampaign->getId())
        );

        // fetch campaign from API and assert the removal
        $storedCampaign = BannerSDK::getCampaign($storedCampaign->getId());

        $this->assertNull($storedCampaign->getBanners());

        // Delete banner and campaign after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteCampaign($storedCampaign->getId());
    }
}
