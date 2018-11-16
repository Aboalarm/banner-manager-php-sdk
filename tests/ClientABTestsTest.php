<?php

namespace aboalarm\BannerManagerSdk\Test;


use aboalarm\BannerManagerSdk\Entity\ABTest;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use BannerSDK;

class ClientABTestsTest extends TestCase
{
    public function testGetABTests()
    {
        /** @var PaginatedCollection $abtestCollection */
        $abtestCollection = BannerSDK::getABTests();

        $this->assertInstanceOf(PaginatedCollection::class, $abtestCollection);

        foreach ($abtestCollection->getItems() as $abtest) {
            $this->assertInstanceOf(ABTest::class, $abtest);
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
}
