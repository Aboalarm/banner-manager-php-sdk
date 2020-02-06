<?php

namespace aboalarm\BannerManagerSdk\Entity;


use Exception;

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
     * @var bool
     */
    private $isActive = false;

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
     * @var bool
     */
    private $hasActiveTiming;

    /**
     * Campaign constructor.
     *
     * @param array $data Data from json response
     *
     * @throws Exception
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

            $this->isActive = isset($data['is_active'])
                ? boolval($data['is_active'])
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

            $this->abTest = (isset($data['ab_test']) && $data['ab_test']) ? new ABTest($data['ab_test']) : null;
            $this->hasActiveTiming = isset($data['status']) ? $data['status'] : false;
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return Campaign
     */
    public function setIsActive(bool $isActive): Campaign
    {
        $this->isActive = $isActive;

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
     * @return bool
     */
    public function isHasActiveTiming(): bool
    {
        return $this->hasActiveTiming;
    }

    /**
     * @param bool $hasActiveTiming
     * @return Campaign
     */
    public function setHasActiveTiming(bool $hasActiveTiming)
    {
        $this->hasActiveTiming = $hasActiveTiming;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name'                      => $this->name,
            'description'               => $this->description,
            'weight'                    => $this->weight,
            'ab_test'                   => ($this->abTest instanceof ABTest) ? $this->abTest->getId() : null,
            'app_mobile_always_hotline' => $this->appMobileAlwaysHotline,
            'tracking_disabled'         => $this->trackingDisabled,
            'is_active'                 => $this->isActive,
        ];
    }
}
