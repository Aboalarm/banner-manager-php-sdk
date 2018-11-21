<?php

namespace aboalarm\BannerManagerSdk\Entity;


use DateTime;

/**
 * Class Base
 * @package aboalarm\BannerManagerSdk\Entity
 */
abstract class Base implements EntityInterface
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var DateTime|null
     */
    private $createdAt;

    /**
     * @var DateTime|null
     */
    private $updatedAt;

    /**
     * Base constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        if($data) {
            $this->id = $data['id'];
            $this->createdAt = isset($data['created_at']) ? new DateTime($data['created_at']) : null;
            $this->updatedAt = isset($data['updated_at']) ? new DateTime($data['updated_at']) : null;
        }
    }

    /**
     * Return true if new
     *
     * @return bool
     */
    public function isNew()
    {
        return $this->getId() ? false: true;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
