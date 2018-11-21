<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use aboalarm\BannerManagerSdk\Pagination\PaginationOptions;
use BannerSDK;

class ClientBannersTest extends TestCase
{
    public function testGetBanners()
    {
        $options = new PaginationOptions();

        $options->setFilter(
            [
                'search' => 'polar',
                'fields' => [
                    'status' => 'new',
                    'approved' => 0,
                ],
            ]
        );

        $options->setSort(
            [
                'name' => 'createdAt',
                'dir' => 'DESC',
            ]
        );

        /** @var PaginatedCollection $banners */
        $banners = BannerSDK::getBanners($options);

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
            ->setText('Test Text')
            ->setApproved(true);

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);
        $this->assertInstanceOf(Banner::class, $storedBanner);

        // Read Banner
        $getBanner = BannerSDK::getBanner($storedBanner->getId());
        $this->assertEquals($storedBanner->getId(), $getBanner->getId());
        $this->assertEquals(
            BannerSDK::getBaseUri().'/preview/'.$storedBanner->getId().'.jpg',
            $getBanner->getPreviewUrl()
        );

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

        // Check campaign sub object
        $getBanner = BannerSDK::getBanner($storedBanner->getId());
        $getCampaigns = $getBanner->getCampaigns();
        $this->assertEquals($storedCampaign->getId(), $getCampaigns[0]->getId());

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

        $this->assertEmpty($storedCampaign->getBanners());

        // Delete banner and campaign after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteCampaign($storedCampaign->getId());
    }

    public function testPostDeleteBannerPositionsBanners()
    {
        $bannerPosition = new BannerPosition();

        $bannerPosition->setDescription('test')
            ->setName('test')
            ->setDevice('mobile')
            ->setViewPort('lg')
            ->setWidth(320)
            ->setHeight(1360);

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($bannerPosition);

        $banner = new Banner();

        $banner->setName('test')
            ->setPath('test.jpg')
            ->setLink('http://www.example.com')
            ->setPhoneNumber('0944532')
            ->setText('Test Text');

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);

        $response = BannerSDK::postBannerBannerPositions(
            $storedBanner->getId(),
            [$storedPosition->getId()]
        );

        $this->assertCount(1, $response);
        $this->assertEquals($storedPosition->getId(), $response[0]['position']);
        $this->assertEquals('ok', $response[0]['status']);
        $this->assertEmpty($response[0]['message']);

        // remove bannerPosition from banner
        $this->assertTrue(
            BannerSDK::removeBannerPositionFromBanner(
                $storedBanner->getId(),
                $storedPosition->getId()
            )
        );

        // fetch banner from API and assert the removal
        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::getBanner($storedBanner->getId());

        $this->assertNull($storedBanner->getBannerPositions());

        // Delete banner and bannerPosition after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteBannerPosition($storedPosition->getId());
    }
}
