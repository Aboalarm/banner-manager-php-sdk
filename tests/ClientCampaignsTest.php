<?php
/** @noinspection PhpUndefinedClassInspection */

namespace Aboalarm\BannerManagerSdk\Test;

use Aboalarm\BannerManagerSdk\Entity\Banner;
use Aboalarm\BannerManagerSdk\Entity\Campaign;
use Aboalarm\BannerManagerSdk\Entity\Timing;
use Aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use Aboalarm\BannerManagerSdk\Pagination\PaginationOptions;
use BannerSDK;

class ClientCampaignsTest extends TestCase
{
    public function testGetCampaigns()
    {
        $options = new PaginationOptions();

        $options->setFilter(
            [
                'search' => 'polar',
                'fields' => [
                    'weight' => 1,
                ],
            ]
        );

        $options->setSort(
            [
                'name' => 'createdAt',
                'dir' => 'DESC',
            ]
        );

        /** @var PaginatedCollection $campaigns */
        $campaigns = BannerSDK::getCampaigns($options);

        $this->assertInstanceOf(PaginatedCollection::class, $campaigns);

        foreach ($campaigns->getItems() as $banner) {
            $this->assertInstanceOf(Campaign::class, $banner);
        }
    }

    public function testCampaignCRUD()
    {
        $campaign = $this->createCampaign();

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);
        $this->assertInstanceOf(Campaign::class, $storedCampaign);

        $storedCampaign->setName(TestConstants::CAMPAIGN_NAME_UPDATED);
        $storedCampaign->setAppMobileAlwaysHotline(true);
        $storedCampaign->setTrackingDisabled(true);

        /** @var Campaign $updatedCampaign */
        $updatedCampaign = BannerSDK::putCampaign($storedCampaign);
        $this->assertEquals(TestConstants::CAMPAIGN_NAME_UPDATED, $updatedCampaign->getName());
        $this->assertEquals(true, $updatedCampaign->isAppMobileAlwaysHotline());
        $this->assertEquals(true, $updatedCampaign->isTrackingDisabled());

        $this->assertTrue(BannerSDK::deleteCampaign($updatedCampaign->getId()));
    }

    public function testPostCampaignBanners()
    {
        $campaign = $this->createCampaign();

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);

        $banner = $this->createBanner();

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

        $this->assertEmpty($storedCampaign->getBanners());

        // Delete banner and campaign after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteCampaign($storedCampaign->getId());
    }

    public function testTimingCRUD()
    {
        $campaign = $this->createCampaign();

        /** @var Campaign $campaign */
        $campaign = BannerSDK::postCampaign($campaign);

        $timing = $this->createTiming();

        /** @var Timing $storedTiming */
        $storedTiming = BannerSDK::postCampaignTiming($campaign->getId(), $timing);

        $this->assertInstanceOf(Timing::class, $storedTiming);

        $storedTiming->setTimeFrom(TestConstants::CAMPAIGN_TIMING_TIME_FROM_UPDATED);

        /** @var Timing $updatedTiming */
        $updatedTiming = BannerSDK::putCampaignTiming($campaign->getId(), $storedTiming);
        $this->assertEquals(
            TestConstants::CAMPAIGN_TIMING_TIME_FROM_UPDATED,
            $updatedTiming->getTimeFrom()
        );

        $this->assertTrue(
            BannerSDK::deleteCampaignTiming($campaign->getId(), $updatedTiming)
        );

        //Remove campaign
        BannerSDK::deleteCampaign($campaign->getId());
    }

    public function testInvalidCampaignData()
    {
        $missingCampaignId = 'cmp_12345';

        /** @var Campaign $campaign */
        $campaign = BannerSDK::getCampaign($missingCampaignId);

        $this->assertCount(1, $campaign->getErrors());
        $this->assertTrue($campaign->hasErrors());

        /** @var Campaign $invalidCampaign */
        $invalidCampaign = BannerSDK::postCampaign(new Campaign());

        $this->assertCount(1, $invalidCampaign->getErrors());
        $this->assertTrue($invalidCampaign->hasErrors());
        $this->assertNotEmpty( $invalidCampaign->getFieldErrors());
        $this->assertCount(1, $invalidCampaign->getFieldErrors());
    }
}
