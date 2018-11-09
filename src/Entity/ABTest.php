<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class ABTest
 * @package aboalarm\BannerManagerSdk\Entity
 */
class ABTest extends Base
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
     * @var Campaign[]|null
     */
    private $campaigns;

    /**
     * ABTest constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data)
    {
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return Campaign[]|null
     */
    public function getCampaigns(): array
    {
        return $this->campaigns;
    }

    /**
     * @param Campaign[]|null $campaigns
     */
    public function setCampaigns(array $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        $data['name'] = $this->name;
        $data['description'] = $this->description;

        if ($this->campaigns) {
            $data['campaigns'] = [];
            foreach ($this->campaigns as $campaign) {
                $data['campaigns'][] = $campaign->toArray();
            }
        } else {
            $data['campaigns'] = null;
        }

        return $data;
    }
}
