<?php

namespace aboalarm\BannerManagerSdk\Entity;


use phpDocumentor\Reflection\Types\Nullable;

/**
 * Class Campaign
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Campaign extends Base
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var int|null
     */
    private $weight;

    /**
     * @var bool
     */
    private $appMobileAlwaysHotline = false;

    /**
     * @var bool
     */
    private $trackingDisabled = false;

    /**
     * @var Banner[]|null
     */
    private $banners;

    /**
     * @var Timing[]|null
     */
    private $timings;

    /**
     * @var ABTest|null
     */
    private $abTest;

    /**
     * Campaign constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        $this->banners = [];
        $this->timings = [];

        parent::__construct($data);

        if ($data && !isset($data['error'])) {
            $this->name = isset($data['name']) ? $data['name'] : null;
            $this->description = isset($data['description']) ? $data['description'] : null;
            $this->weight = isset($data['weight']) ? $data['weight'] : null;
            $this->appMobileAlwaysHotline = isset($data['app_mobile_always_hotline'])
                ? boolval($data['app_mobile_always_hotline'])
                : false;
            $this->trackingDisabled = isset($data['tracking_disabled'])
                ? boolval($data['tracking_disabled'])
                : false;

            if (isset($data['banners']) && $data['banners']) {
                foreach ($data['banners'] as $banner) {
                    $this->banners[] = new Banner($banner);
                }
            }

            if (isset($data['campaign_timings']) && $data['campaign_timings']) {
                foreach ($data['campaign_timings'] as $timing) {
                    $this->timings[] = new Timing($timing);
                }
            }

            if (isset($data['ab_test']) && $data['ab_test']) {
                $this->abTest = new ABTest($data['ab_test']);
            } else {
                $this->abTest = null;
            }
        }
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Campaign
     */
    public function setName(string $name): Campaign
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Campaign
     */
    public function setDescription(string $description): Campaign
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     *
     * @return Campaign
     */
    public function setWeight(int $weight): Campaign
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAppMobileAlwaysHotline(): bool
    {
        return $this->appMobileAlwaysHotline;
    }

    /**
     * @param bool $appMobileAlwaysHotline
     *
     * @return Campaign
     */
    public function setAppMobileAlwaysHotline(bool $appMobileAlwaysHotline): Campaign
    {
        $this->appMobileAlwaysHotline = $appMobileAlwaysHotline;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTrackingDisabled(): bool
    {
        return $this->trackingDisabled;
    }

    /**
     * @param bool $trackingDisabled
     *
     * @return Campaign
     */
    public function setTrackingDisabled(bool $trackingDisabled): Campaign
    {
        $this->trackingDisabled = $trackingDisabled;

        return $this;
    }

    /**
     * @return Banner[]
     */
    public function getBanners(): array
    {
        return $this->banners;
    }

    /**
     * @param Banner[]|null $banners
     *
     * @return Campaign
     */
    public function setBanners(array $banners): Campaign
    {
        $this->banners = $banners;

        return $this;
    }

    /**
     * @return Timing[]
     */
    public function getTimings(): array
    {
        return $this->timings;
    }

    /**
     * @param Timing[]|null $timings
     *
     * @return Campaign
     */
    public function setTimings(array $timings): Campaign
    {
        $this->timings = $timings;

        return $this;
    }

    /**
     * @return ABTest|null
     */
    public function getAbTest()
    {
        return $this->abTest;
    }

    /**
     * @param ABTest|null $abTest
     *
     * @return Campaign
     */
    public function setAbTest(ABTest $abTest = null): Campaign
    {
        $this->abTest = $abTest;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        if ($this->name !== null) {
            $data['name'] = $this->name;
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        if ($this->weight !== null) {
            $data['weight'] = $this->weight;
        }

        if ($this->abTest instanceof ABTest) {
            $data['ab_test'] = $this->abTest->getId();
        }

        $data['app_mobile_always_hotline'] = $this->appMobileAlwaysHotline;

        $data['tracking_disabled'] = $this->trackingDisabled;

        return $data;
    }
}
