<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class ABTest
 * @package aboalarm\BannerManagerSdk\Entity
 */
class ABTest extends Base
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
     * @var Campaign[]|null
     */
    private $campaigns;

    /**
     * @var Timing[]|null
     */
    private $timings;

    /**
     * ABTest constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        $this->campaigns = [];
        $this->timings = [];

        parent::__construct($data);

        if ($data && !isset($data['error'])) {
            $this->name = isset($data['name']) ? $data['name'] : null;
            $this->description = isset($data['description']) ? $data['description'] : null;

            if (isset($data['campaigns']) && $data['campaigns']) {
                foreach ($data['campaigns'] as $campaign) {
                    $this->campaigns[] = new Campaign($campaign);
                }
            }

            if (isset($data['timings']) && $data['timings']) {
                foreach ($data['timings'] as $timing) {
                    $this->timings[] = new Timing($timing);
                }
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
     * @return ABTest
     */
    public function setName(string $name): ABTest
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
     * @return ABTest
     */
    public function setDescription(string $description): ABTest
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Campaign[]
     */
    public function getCampaigns(): array
    {
        return $this->campaigns;
    }

    /**
     * @param Campaign[]|null $campaigns
     *
     * @return ABTest
     */
    public function setCampaigns(array $campaigns): ABTest
    {
        $this->campaigns = $campaigns;

        return $this;
    }

    /**
     * Get Timings
     *
     * @return Timing[]|null
     */
    public function getTimings(): array
    {
        return $this->timings;
    }

    /**
     * Set Timings
     *
     * @param Timing[]|null $timings
     *
     * @return $this
     */
    public function setTimings(array $timings)
    {
        $this->timings = $timings;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->name) {
            $data['name'] = $this->name;
        }

        if ($this->description) {
            $data['description'] = $this->description;
        }

        return $data;
    }
}
