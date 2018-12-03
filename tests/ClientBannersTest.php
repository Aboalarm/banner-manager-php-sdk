<?php
/** @noinspection PhpUndefinedClassInspection */

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
        $banner = $this->createBanner();

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);
        $this->assertInstanceOf(Banner::class, $storedBanner);

        // Read Banner
        /** @var Banner $getBanner */
        $getBanner = BannerSDK::getBanner($storedBanner->getId());
        $this->assertEquals($storedBanner->getId(), $getBanner->getId());
        $this->assertEquals(
            BannerSDK::getBaseUri().'/preview/'.$storedBanner->getId().'.jpg',
            $getBanner->getPreviewUrl()
        );

        $storedBanner->setName(TestConstants::BANNER_NAME_UPDATED);

        /** @var Banner $updatedBanner */
        $updatedBanner = BannerSDK::putBanner($storedBanner);
        $this->assertEquals(TestConstants::BANNER_NAME_UPDATED, $updatedBanner->getName());

        $this->assertTrue(BannerSDK::deleteBanner($updatedBanner->getId()));
    }

    public function testPostDeleteCampaignBanners()
    {
        $campaign = $this->createCampaign();

        /** @var Campaign $storedCampaign */
        $storedCampaign = BannerSDK::postCampaign($campaign);

        $banner = $this->createBanner();

        /** @var Banner $storedBanner */
        $storedBanner = BannerSDK::postBanner($banner);

        $response = BannerSDK::postBannerCampaigns(
            $storedBanner->getId(),
            [$storedCampaign->getId()]
        );

        // Check campaign sub object
        /** @var Banner $getBanner */
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
        $bannerPosition = $this->createBannerPosition();

        /** @var BannerPosition $storedPosition */
        $storedPosition = BannerSDK::postBannerPosition($bannerPosition);

        $banner = $this->createBanner();

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

        $this->assertEmpty($storedBanner->getBannerPositions());

        // Delete banner and bannerPosition after tests
        BannerSDK::deleteBanner($storedBanner->getId());
        BannerSDK::deleteBannerPosition($storedPosition->getId());
    }

    public function testInvalidBannerData()
    {
        $missingBannerId = 'ban_12345';

        /** @var Banner $banner */
        $banner = BannerSDK::getBanner($missingBannerId);

        $this->assertCount(1, $banner->getErrors());
        $this->assertTrue($banner->hasErrors());

        /** @var Banner $invalidBanner */
        $invalidBanner = BannerSDK::postBanner($this->createInvalidBanner());

        $this->assertCount(1, $invalidBanner->getErrors());
        $this->assertTrue($invalidBanner->hasErrors());
        $this->assertNotEmpty( $invalidBanner->getFieldErrors());
        $this->assertCount(2, $invalidBanner->getFieldErrors());

        /** @var Banner $banner */
        $banner = BannerSDK::postBanner($this->createBanner());

        $banner->setLink(TestConstants::BANNER_INVALID_LINK);
        $invalidBanner = BannerSDK::putBanner($banner);

        $this->assertCount(1, $invalidBanner->getErrors());
        $this->assertTrue($invalidBanner->hasErrors());
        $this->assertNotEmpty( $invalidBanner->getFieldErrors());
    }
}
