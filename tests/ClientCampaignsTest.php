<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;

use BannerSDK;

class ClientCampaignsTest extends TestCase
{
    public function testGetCampaigns()
    {
        /** @var PaginatedCollection $campaignsCollection */
        $campaignsCollection = BannerSDK::getCampaigns();

        $this->assertInstanceOf(PaginatedCollection::class, $campaignsCollection);

        foreach ($campaignsCollection->getItems() as $campaign) {
            $this->assertInstanceOf(Campaign::class, $campaign);
        }
    }

    public function testCampaignCRUD()
    {
        $campaign = new Campaign();

        $campaign->setWeight(1)
            ->setDescription('test')
            ->setName('test');

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);
        $this->assertInstanceOf(Campaign::class, $storedCampaign);

        $storedCampaign->setName('EDITED BY PUT');

        /** @var Campaign $updatedCampaign */
        $updatedCampaign = BannerSDK::putCampaign($storedCampaign);
        $this->assertEquals('EDITED BY PUT', $updatedCampaign->getName());

        $this->assertTrue(BannerSDK::deleteCampaign($updatedCampaign->getId()));
    }

    public function testPostCampaignBanners()
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

        $response = BannerSDK::postCampaignBanners(
            $storedCampaign->getId(),
            [$storedBanner->getId()]
        );

        $this->assertCount(1, $response);
        $this->assertEquals($storedBanner->getId(), $response[0]['banner']);
        $this->assertEquals('ok', $response[0]['status']);
        $this->assertEmpty($response[0]['message']);

        // remove banner from campaign
        $this->assertTrue(
            BannerSDK::removeBannerFromCampaign($storedCampaign->getId(), $storedBanner->getId())
        );

        // fetch campaign from API and assert the removal
        $storedCampaign = BannerSDK::getCampaign($storedCampaign->getId());

        $this->assertNull($storedCampaign->getBanners());

        // Delete banner and campaign after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteCampaign($storedCampaign->getId());
    }
}
