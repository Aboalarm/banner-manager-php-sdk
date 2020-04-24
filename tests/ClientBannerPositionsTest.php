<?php
/** @noinspection PhpUndefinedClassInspection */

namespace Aboalarm\BannerManagerSdk\Test;

use Aboalarm\BannerManagerSdk\Entity\Banner;
use Aboalarm\BannerManagerSdk\Entity\BannerPosition;
use Aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;

use Aboalarm\BannerManagerSdk\Pagination\PaginationOptions;
use BannerSDK;

class ClientBannerPositionsTest extends TestCase
{
    public function testGetBannerPositions()
    {
        $options = new PaginationOptions();

        $options->setFilter(
            [
                'search' => 'vertical',
                'fields' => [
                    'device' => 'web',
                    'viewPort' => 'lg',
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
        $banners = BannerSDK::getBannerPositions($options);

        $this->assertInstanceOf(PaginatedCollection::class, $banners);

        foreach ($banners->getItems() as $banner) {
            $this->assertInstanceOf(BannerPosition::class, $banner);
        }
    }

    public function testBannerPositionCRUD()
    {
        $position = $this->createBannerPosition();

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($position);
        $this->assertInstanceOf(BannerPosition::class, $storedPosition);

        $storedPosition->setName(TestConstants::BANNER_POSITION_UPDATED);

        $this->assertEquals(TestConstants::BANNER_POSITION_GA_TYPE, $storedPosition->getGaType());
        $this->assertEquals(
            TestConstants::BANNER_POSITION_GA_KEYWORD,
            $storedPosition->getGaKeyword()
        );

        /** @var BannerPosition $updatedPosition */
        $updatedPosition = BannerSDK::putBannerPosition($storedPosition);
        $this->assertEquals(TestConstants::BANNER_POSITION_UPDATED, $updatedPosition->getName());

        $this->assertTrue(BannerSDK::deleteBannerPosition($updatedPosition->getId()));
    }

    public function testBannerPositionCRUDWithoutDeviceAndViewPort()
    {
        $position = $this->createBannerPosition();

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($position);
        $this->assertInstanceOf(BannerPosition::class, $storedPosition);

        $storedPosition->setName(TestConstants::BANNER_POSITION_UPDATED);

        /** @var BannerPosition $updatedPosition */
        $updatedPosition = BannerSDK::putBannerPosition($storedPosition);
        $this->assertEquals(TestConstants::BANNER_POSITION_UPDATED, $updatedPosition->getName());

        $this->assertTrue(BannerSDK::deleteBannerPosition($updatedPosition->getId()));
    }

    public function testPostDeleteBannersBannerPositions()
    {
        $banner = $this->createBanner();

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);

        $bannerPosition = $this->createBannerPosition();

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($bannerPosition);

        $response = BannerSDK::postBannerPositionBanners(
            $storedPosition->getId(),
            [$storedBanner->getId()]
        );

        $this->assertCount(1, $response);
        $this->assertEquals($storedBanner->getId(), $response[0]['banner']);
        $this->assertEquals('ok', $response[0]['status']);
        $this->assertEmpty($response[0]['message']);

        // remove banner from banner position
        $this->assertTrue(
            BannerSDK::removeBannerFromBannerPosition(
                $storedPosition->getId(),
                $storedBanner->getId()
            )
        );

        // fetch banner from API and assert the removal
        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::getBanner($storedBanner->getId());

        $this->assertEmpty($storedBanner->getBannerPositions());

        // Delete banner and bannerPosition after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteBannerPosition($storedPosition->getId());
    }

    public function testInvalidBannerPositionData()
    {
        $missingBannerPositionId = 'cpos_12345';

        /** @var BannerPosition $bannerPosition */
        $bannerPosition = BannerSDK::getBannerPosition($missingBannerPositionId);

        $this->assertCount(1, $bannerPosition->getErrors());
        $this->assertTrue($bannerPosition->hasErrors());

        /** @var BannerPosition $invalidBannerPosition */
        $invalidBannerPosition = BannerSDK::postBannerPosition(new BannerPosition());

        $this->assertCount(1, $invalidBannerPosition->getErrors());
        $this->assertTrue($invalidBannerPosition->hasErrors());
        $this->assertNotEmpty( $invalidBannerPosition->getFieldErrors());
        $this->assertCount(1, $invalidBannerPosition->getFieldErrors());
    }
}
