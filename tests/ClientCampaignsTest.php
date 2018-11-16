<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Entity\Timing;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;

use BannerSDK;

class ClientCampaignsTest extends TestCase
{
    public function testGetCampaigns()
    {
        $filter = [
            'search' => 'polar',
            'fields' => [
                'weight' => 1
            ]
        ];

        $sort = [
            'name' => 'createdAt',
            'dir' => 'DESC'
        ];

        /** @var PaginatedCollection $campaigns */
        $campaigns = BannerSDK::getCampaigns($filter, $sort);

        $this->assertInstanceOf(PaginatedCollection::class, $campaigns);

        foreach ($campaigns->getItems() as $banner) {
            $this->assertInstanceOf(Campaign::class, $banner);
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

    public function testTimingCRUD()
    {
        $campaign = new Campaign();

        $campaign->setWeight(1)
            ->setDescription('test')
            ->setName('test');

        /** @var Campaign $campaign */
        $campaign = BannerSDK::postCampaign($campaign);

        $timing = new Timing();
        $timing->setType(Timing::TYPE_WORKDAYS)
            ->setTimeFrom('10:00')
            ->setTimeUntil('16:00');

        /** @var Timing $storedTiming */
        $storedTiming = BannerSDK::postCampaignTiming($campaign->getId(), $timing);

        $this->assertInstanceOf(Timing::class, $storedTiming);

        $storedTiming->setTimeFrom('09:00');

        /** @var Timing $updatedTiming */
        $updatedTiming = BannerSDK::putCampaignTiming($campaign->getId(), $storedTiming);
        $this->assertEquals('09:00', $updatedTiming->getTimeFrom());

        $this->assertTrue(
            BannerSDK::deleteCampaignTiming($campaign->getId(), $updatedTiming)
        );

        //Remove campaign
        BannerSDK::deleteCampaign($campaign->getId());
    }
}
