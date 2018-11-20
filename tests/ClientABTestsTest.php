<?php

namespace aboalarm\BannerManagerSdk\Test;


use aboalarm\BannerManagerSdk\Entity\ABTest;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Entity\Timing;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use aboalarm\BannerManagerSdk\Pagination\PaginationOptions;
use BannerSDK;

class ClientABTestsTest extends TestCase
{
    public function testGetABTests()
    {
        $options = new PaginationOptions();

        $options->setFilter(
            [
                'search' => 'polar',
                'fields' => [],
            ]
        );

        $options->setSort(
            [
                'name' => 'createdAt',
                'dir' => 'DESC',
            ]
        );

        /** @var PaginatedCollection $campaigns */
        $campaigns = BannerSDK::getABTests($options);

        $this->assertInstanceOf(PaginatedCollection::class, $campaigns);

        foreach ($campaigns->getItems() as $banner) {
            $this->assertInstanceOf(ABTest::class, $banner);
        }
    }

    public function testABTestCRUD()
    {
        $abtest = new ABTest();

        $abtest->setDescription('test')
            ->setName('test');

        /** @var ABTest $storedABTest */
        $storedABTest = BannerSDK::postABTest($abtest);
        $this->assertInstanceOf(ABTest::class, $storedABTest);

        $storedABTest->setName('EDITED BY PUT');

        /** @var ABTest $updatedABTest */
        $updatedABTest = BannerSDK::putABTest($storedABTest);
        $this->assertEquals('EDITED BY PUT', $updatedABTest->getName());

        $this->assertTrue(BannerSDK::deleteABTest($updatedABTest->getId()));
    }

    public function testPostDeleteCampaignABTests()
    {
        $campaign = new Campaign();

        $campaign->setWeight(1)
            ->setDescription('test')
            ->setName('test');

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);

        $abTest = new ABTest();

        $abTest->setName('test')
            ->setDescription('test');

        /** @var ABTest $storedABTest */
        $storedABTest = BannerSDK::postABTest($abTest);

        $response = BannerSDK::postABtestCampaigns(
            $storedABTest->getId(),
            [$storedCampaign->getId()]
        );

        $this->assertCount(1, $response);
        $this->assertEquals($storedCampaign->getId(), $response[0]['campaign']);
        $this->assertEquals('ok', $response[0]['status']);
        $this->assertEmpty($response[0]['message']);

        // remove campaign from ab-test
        $this->assertTrue(
            BannerSDK::removeCampaignFromABTest($storedABTest->getId(), $storedCampaign->getId())
        );

        // fetch abtest from API and assert the removal
        $storedABTest = BannerSDK::getABTest($storedABTest->getId());

        $this->assertEmpty($storedABTest->getCampaigns());

        // Delete banner and campaign after tests
        BannerSDK::deleteABTest($storedABTest->getId());
        BannerSDK::deleteCampaign($storedCampaign->getId());
    }

    public function testTimingCRUD()
    {
        $abtest = new ABTest();

        $abtest->setDescription('test')
            ->setName('test');

        /** @var ABtest $abtest */
        $abtest = BannerSDK::postABTest($abtest);

        $timing = new Timing();
        $timing->setType(Timing::TYPE_WORKDAYS)
            ->setTimeFrom('10:00')
            ->setTimeUntil('16:00');

        /** @var Timing $storedTiming */
        $storedTiming = BannerSDK::postABTestTiming($abtest->getId(), $timing);

        $this->assertInstanceOf(Timing::class, $storedTiming);

        $storedTiming->setTimeFrom('09:00');

        /** @var Timing $updatedTiming */
        $updatedTiming = BannerSDK::putABTestTiming($abtest->getId(), $storedTiming);
        $this->assertEquals('09:00', $updatedTiming->getTimeFrom());

        $this->assertTrue(
            BannerSDK::deleteABTestTiming($abtest->getId(), $updatedTiming)
        );

        //Remove abtest
        BannerSDK::deleteABTest($abtest->getId());
    }
}
