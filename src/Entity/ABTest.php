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
        if ($data) {
            parent::__construct($data);

            $this->name = $data['name'];
            $this->description = $data['description'];

            if ($data['campaigns']) {
                foreach ($data['campaigns'] as $campaign) {
                    $this->campaigns[] = new Campaign($campaign);
                }
            } else {
                $this->campaigns = null;
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
     * @return Campaign[]|null
     */
    public function getCampaigns()
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

        if ($this->campaigns) {
            $data['campaigns'] = [];
            foreach ($this->campaigns as $campaign) {
                $data['campaigns'][] = $campaign->toArray();
            }
        }

        return $data;
    }
}
