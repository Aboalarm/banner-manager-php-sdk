<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 11/12/18
 * Time: 9:47 AM
 */

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;

use BannerSDK;

class ClientBannerPositionsTest extends TestCase
{
    public function testGetBannerPositions()
    {
        /** @var PaginatedCollection $positionsCollection */
        $positionsCollection = BannerSDK::getBannerPositions();

        $this->assertInstanceOf(PaginatedCollection::class, $positionsCollection);

        foreach ($positionsCollection->getItems() as $position) {
            $this->assertInstanceOf(BannerPosition::class, $position);
        }
    }

    public function testBannerPositionCRUD()
    {
        $position = new BannerPosition();

        $position->setDescription('test')
            ->setName('test')
            ->setDevice('mobile')
            ->setViewPort('lg')
            ->setWidth(320)
            ->setHeight(1360);

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($position);
        $this->assertInstanceOf(BannerPosition::class, $storedPosition);

        $storedPosition->setName('EDITED BY PUT');

        /** @var BannerPosition $updatedPosition */
        $updatedPosition = BannerSDK::putBannerPosition($storedPosition);
        $this->assertEquals('EDITED BY PUT', $updatedPosition->getName());

        $this->assertTrue(BannerSDK::deleteBannerPosition($updatedPosition->getId()));
    }
}
