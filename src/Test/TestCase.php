<?php

namespace aboalarm\BannerManagerSdk\Test;

use aboalarm\BannerManagerSdk\Entity\ABTest;
use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Entity\Timing;
use aboalarm\BannerManagerSdk\Laravel\Facade;
use aboalarm\BannerManagerSdk\Laravel\ServiceProvider;
use Exception;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * Load package alias
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'BannerSDK' => Facade::class,
        ];
    }

    /**
     * Create a new banner
     *
     * @return Banner
     * @throws Exception
     */
    public function createBanner()
    {
        $banner = new Banner();

        $banner->setName(TestConstants::BANNER_NAME)
            ->setDescription(TestConstants::BANNER_DESCRIPTION)
            ->setPath(TestConstants::BANNER_IMAGE)
            ->setLink(TestConstants::BANNER_LINK)
            ->setPhoneNumber(TestConstants::BANNER_PHONE)
            ->setText(TestConstants::BANNER_TEXT)
            ->setApproved(true);

        return $banner;
    }

    /**
     * Create a banner that will cause validation errors
     *
     * @return Banner
     * @throws Exception
     */
    public function createInvalidBanner()
    {
        $banner = new Banner();

        $banner->setLink(TestConstants::BANNER_INVALID_LINK);

        return $banner;
    }

    /**
     * Create a new Campaign
     *
     * @return Campaign
     * @throws Exception
     */
    public function createCampaign()
    {
        $campaign = new Campaign();

        $campaign->setWeight(TestConstants::CAMPAIGN_WEIGHT)
            ->setDescription(TestConstants::CAMPAIGN_DESCRIPTION)
            ->setName(TestConstants::CAMPAIGN_NAME);

        return $campaign;
    }

    /**
     * Create a new Banner position
     * @return BannerPosition
     * @throws Exception
     */
    public function createBannerPosition()
    {
        $bannerPosition = new BannerPosition();

        $bannerPosition->setName(TestConstants::BANNER_POSITION)
            ->setDescription(TestConstants::BANNER_POSITION_DESCRIPTION)
            ->setDevice(TestConstants::BANNER_POSITION_DEVICE)
            ->setViewPort(TestConstants::BANNER_POSITION_VIEW_PORT)
            ->setWidth(TestConstants::BANNER_POSITION_WIDTH)
            ->setHeight(TestConstants::BANNER_POSITION_HEIGHT)
            ->setGaKeyword(TestConstants::BANNER_POSITION_GA_KEYWORD)
            ->setGaType(TestConstants::BANNER_POSITION_GA_TYPE);

        return $bannerPosition;
    }

    /**
     * Create new ABTest
     *
     * @return ABTest
     * @throws Exception
     */
    public function createABTest()
    {
        $abtest = new ABTest();

        $abtest->setDescription('test')
            ->setName('test');

        return $abtest;
    }

    /**
     * Create new Timing
     *
     * @return Timing
     * @throws Exception
     */
    public function createTiming()
    {
        $timing = new Timing();
        $timing->setType(Timing::TYPE_WORKDAYS)
            ->setTimeFrom(TestConstants::CAMPAIGN_TIMING_TIME_FROM)
            ->setTimeUntil(TestConstants::CAMPAIGN_TIMING_TIME_UNTIL);

        return $timing;
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function getPositionTemplateMock($id = 'tpl_123')
    {
        return [
            'id'          => $id,
            "created_at"  => "2019-09-03 00:00:00",
            "updated_at"  => "2019-09-03 00:00:00",
            "name"        => " web_cancellation_form_vertical_right",
            "description" => "aboalarm.de web_cancellation_form_vertical_right",
            "portal"      => "aa",
            "static"      => false,
            "device"      => "web",
            "page"        => "cancellation",
            "section"     => "form",
            "position"    => "right",
            "width"       => "160",
            "height"      => "680",
            "ga_type"     => "web_vertical_right",
            "ga_keyword"  => "cancellation_form",
        ];
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function getPositionMock($id = 'pos_123')
    {
        return [
            'id'          => $id,
            'created_at'  => '2018-11-11 00:00:00',
            'updated_at'  => '2018-11-11 00:00:00',
            'name'        => 'test name',
            'description' => 'description',
            'width'       => 100,
            'height'      => 200,
            'ga_type'     => 'ga_type',
            'ga_keyword'  => 'ga_keyword',
            'device'      => 'dumPhone',
            'view_port'   => 'foo',
            'parent'      => null,
            'banners'     => [
                [
                    'id'           => 'ban_123',
                    'created_at'   => '2018-11-09 00:00:00',
                    'updated_at'   => '2018-11-09 00:00:00',
                    'name'         => 'foo',
                    'path'         => 'path.jpg',
                    'text'         => 'text',
                    'link'         => 'google.de',
                    'phone_number' => '021343215',
                    'preview_url'  => 'bar.com/foo.jpg',
                ],
            ],
        ];
    }

    /**
     * @param string $id
     * @param int $width
     * @param int $height
     *
     * @return array
     */
    public function getBannerMock($id = 'ban_123', $width = 300, $height = 300)
    {
        return [
            'id'           => $id,
            'created_at'   => '2018-11-09 00:00:00',
            'updated_at'   => '2018-11-09 00:00:00',
            'name'         => 'foo',
            'path'         => 'path.jpg',
            'text'         => 'text',
            'link'         => 'google.de',
            'phone_number' => '021343215',
            'preview_url'  => 'bar.com/foo.jpg',
            'width'        => $width,
            'height'       => $height,
        ];
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function getCampaignMock($id = 'cm_12345')
    {
        return [
            'id'                        => $id,
            'created_at'                => '2019-03-03 11:21:21',
            'updated_at'                => '2019-03-06 11:11:32',
            'name'                      => TestConstants::CAMPAIGN_NAME,
            'description'               => TestConstants::CAMPAIGN_DESCRIPTION,
            'weight'                    => TestConstants::CAMPAIGN_WEIGHT,
            'app_mobile_always_hotline' => false,
            'tracking_disabled'         => false,
            'banners'                   => [],
            'timings'                   => [],
            'ab_test'                   => null,
        ];
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function getTimingMock($id = 'tim_12345')
    {
        return [
            "type"       => null,
            "date_from"  => null,
            "date_until" => null,
            "time_from"  => null,
            "time_until" => null,
            "is_hotline" => false,
            "campaign"   => null,
            "ab_test"    => null,
            "id"         => $id,
            "created_at" => "2019-03-19 11:21:02",
            "updated_at" => "2019-03-19 11:21:02",
        ];
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function getABTestMock($id = 'abt_12345')
    {
        return [
            "id"          => $id,
            "name"        => "Test Laura",
            "description" => "Test Laura",
            "campaigns"   => [],
            "created_at"  => "2019-02-20 11:03:39",
            "updated_at"  => "2019-02-20 11:03:39",
            "timings"     => [],
        ];
    }
}
