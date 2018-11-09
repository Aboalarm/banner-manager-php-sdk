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

        if ($data['ab_test']) {
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
     * @return string
     */
    public function getDescription(): string
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
     * @return int
     */
    public function getWeight(): int
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
     * @return Banner[]|null
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
     * @return CampaignTiming[]|null
     */
    public function getCampaignTimings(): array
    {
        return $this->campaignTimings;
    }

    /**
     * @param CampaignTiming[]|null $campaignTimings
     *
     * @return Campaign
     */
    public function setCampaignTimings(array $campaignTimings): Campaign
    {
        $this->campaignTimings = $campaignTimings;

        return $this;
    }

    /**
     * @return ABTest|null
     */
    public function getAbTest(): ABTest
    {
        return $this->abTest;
    }

    /**
     * @param ABTest|null $abTest
     *
     * @return Campaign
     */
    public function setAbTest(ABTest $abTest): Campaign
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

        $data['name'] = $this->name;
        $data['description'] = $this->description;
        $data['weight'] = $this->weight;

        if ($this->banners) {
            $data['banners'] = [];
            foreach ($this->banners as $banner) {
                $data['banners'][] = $banner->toArray();
            }
        } else {
            $data['banners'] = null;
        }

        if ($this->campaignTimings) {
            $data['campaign_timings'] = [];
            foreach ($this->campaignTimings as $campaignTiming) {
                $data['campaign_timings'][] = $campaignTiming->toArray();
            }
        } else {
            $data['campaign_timings'] = null;
        }

        if ($this->abTest) {
            $data['ab_test'] = [];
            $data['ab_test'] = $this->abTest->toArray();
        } else {
            $data['ab_test'] = null;
        }

        return $data;
    }
}
