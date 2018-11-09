<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class Campaign
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Campaign extends Base
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $weight;

    /**
     * @var Banner[]|null
     */
    private $banners;

    /**
     * @var CampaignTiming[]|null
     */
    private $campaignTimings;

    /**
     * @var ABTest|null
     */
    private $abTest;

    /**
     * Campaign constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->weight = $data['weight'];

        if ($data['banners']) {
            foreach ($data['banners'] as $banner) {
                $this->banners[] = new Banner($banner);
            }
        } else {
            $this->banners = null;
        }

        if ($data['campaign_timings']) {
            foreach ($data['campaign_timings'] as $campaignTiming) {
                $this->campaignTimings[] = new Banner($campaignTiming);
            }
        } else {
            $this->campaignTimings = null;
        }

        if($data['ab_test']) {
            $this->abTest = new ABTest($data['ab_test']);
        } else {
            $this->abTest = null;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return Banner[]|null
     */
    public function getBanners(): array
    {
        return $this->banners;
    }

    /**
     * @return CampaignTiming[]|null
     */
    public function getCampaignTimings(): array
    {
        return $this->campaignTimings;
    }

    /**
     * @return ABTest|null
     */
    public function getAbTest(): ABTest
    {
        return $this->abTest;
    }
}
