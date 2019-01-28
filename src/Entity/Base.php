<?php

namespace aboalarm\BannerManagerSdk\Entity;


use aboalarm\BannerManagerSdk\Entity\Traits\ErrorTrait;
use DateTime;

/**
 * Class Base
 * @package aboalarm\BannerManagerSdk\Entity
 */
abstract class Base implements EntityInterface
{
    use ErrorTrait;

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
        if($data && !isset($data['error'])) {
            $this->id = isset($data['id']) ? $data['id'] : null;
            $this->createdAt = isset($data['created_at']) ? new DateTime($data['created_at']) : null;
            $this->updatedAt = isset($data['updated_at']) ? new DateTime($data['updated_at']) : null;
        }

        if (isset($data['error'])) {
            $this->setErrors([$data['error']]);
            if(isset($data['fields'])) {
                $this->setFieldErrors($data['fields']);
            }
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
     * Need to allow null to be able to copy objects
     *
     * @param string $id
     */
    public function setId(string $id = null)
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
