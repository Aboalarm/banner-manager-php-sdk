<?php
/** @noinspection PhpUndefinedClassInspection */

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
        $abtest = $this->createABTest();

        /** @var ABTest $storedABTest */
        $storedABTest = BannerSDK::postABTest($abtest);
        $this->assertInstanceOf(ABTest::class, $storedABTest);

        $storedABTest->setName(TestConstants::BANNER_AB_GROUP_UPDATED);

        /** @var ABTest $updatedABTest */
        $updatedABTest = BannerSDK::putABTest($storedABTest);
        $this->assertEquals(TestConstants::BANNER_AB_GROUP_UPDATED, $updatedABTest->getName());

        $this->assertTrue(BannerSDK::deleteABTest($updatedABTest->getId()));
    }

    public function testPostDeleteCampaignABTests()
    {
        $campaign = $this->createCampaign();

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);

        $abTest = $this->createABTest();

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
        $abtest = $this->createABTest();

        /** @var ABtest $abtest */
        $abtest = BannerSDK::postABTest($abtest);

        $timing = $this->createTiming();

        /** @var Timing $storedTiming */
        $storedTiming = BannerSDK::postABTestTiming($abtest->getId(), $timing);

        $this->assertInstanceOf(Timing::class, $storedTiming);

        $storedTiming->setTimeFrom(TestConstants::CAMPAIGN_TIMING_TIME_FROM_UPDATED);

        /** @var Timing $updatedTiming */
        $updatedTiming = BannerSDK::putABTestTiming($abtest->getId(), $storedTiming);
        $this->assertEquals(
            TestConstants::CAMPAIGN_TIMING_TIME_FROM_UPDATED,
            $updatedTiming->getTimeFrom()
        );

        $this->assertTrue(
            BannerSDK::deleteABTestTiming($abtest->getId(), $updatedTiming)
        );

        //Remove abtest
        BannerSDK::deleteABTest($abtest->getId());
    }

    public function testInvalidABTestData()
    {
        $missingABTestId = 'abt_12345';

        /** @var ABTest $abtest */
        $abtest = BannerSDK::getABTest($missingABTestId);

        $this->assertCount(1, $abtest->getErrors());
        $this->assertTrue($abtest->hasErrors());

        // Post invalid ABTest
        /** @var ABTest $invalidABTest */
        $invalidABTest = BannerSDK::postABTest(new ABTest());

        $this->assertCount(1, $invalidABTest->getErrors());
        $this->assertTrue($invalidABTest->hasErrors());
        $this->assertNotEmpty( $invalidABTest->getFieldErrors());
        $this->assertCount(1, $invalidABTest->getFieldErrors());
    }
}
