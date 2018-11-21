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
     * ABTest constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        $this->campaigns = [];

        if ($data) {
            parent::__construct($data);

            $this->name = isset($data['name']) ? $data['name'] : null;
            $this->description = isset($data['description']) ? $data['description'] : null;

            if (isset($data['campaigns']) && $data['campaigns']) {
                foreach ($data['campaigns'] as $campaign) {
                    $this->campaigns[] = new Campaign($campaign);
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
     * @return array
     */
    public function toArray(): array
    {
        $data = [];

        if($this->name) {
            $data['name'] = $this->name;
        }

        if($this->description) {
            $data['description'] = $this->description;
        }

        return $data;
    }
}
