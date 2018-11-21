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

        if ($data) {
            parent::__construct($data);

            $this->name = $data['name'];
            $this->description = $data['description'];
            $this->weight = $data['weight'];

            if ($data['banners']) {
                foreach ($data['banners'] as $banner) {
                    $this->banners[] = new Banner($banner);
                }
            }

            if ($data['campaign_timings']) {
                foreach ($data['campaign_timings'] as $timing) {
                    $this->timings[] = new Timing($timing);
                }
            }

            if ($data['ab_test']) {
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

        if ($this->name) {
            $data['name'] = $this->name;
        }

        if ($this->description) {
            $data['description'] = $this->description;
        }

        if ($this->weight) {
            $data['weight'] = $this->weight;
        }

        if ($this->abTest instanceof ABTest) {
            $data['ab_test'] = $this->abTest->getId();
        }

        return $data;
    }
}
