<?php

namespace aboalarm\BannerManagerSdk\Test;


use aboalarm\BannerManagerSdk\Entity\ABTest;
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
}
