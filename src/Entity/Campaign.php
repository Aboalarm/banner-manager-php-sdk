<?php

namespace aboalarm\BannerManagerSdk\Entity;


use DateTime;

/**
 * Class Campaign
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Campaign
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var DateTime
     */
    private $updatedAt;

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
        $this->id = $data['id'];
        $this->createdAt = new DateTime($data['created_at']);
        $this->updatedAt = new DateTime($data['updated_at']);
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
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
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
