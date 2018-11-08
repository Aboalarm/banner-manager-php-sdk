<?php

namespace aboalarm\BannerManagerSdk\Entity;


use DateTime;

/**
 * Class ABTest
 * @package aboalarm\BannerManagerSdk\Entity
 */
class ABTest
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
        $this->id = $data['id'];
        $this->createdAt = new DateTime($data['created_at']);
        $this->updatedAt = new DateTime($data['updated_at']);
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
     * @return Campaign[]|null
     */
    public function getCampaigns(): array
    {
        return $this->campaigns;
    }
}
