<?php

namespace Aboalarm\BannerManagerSdk\Entity;


use Aboalarm\BannerManagerSdk\Entity\Traits\ErrorTrait;
use DateTime;
use Exception;

/**
 * Class Base
 * @package Aboalarm\BannerManagerSdk\Entity
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
     * @var array Raw response data
     */
    private $raw;

    /**
     * Base constructor.
     *
     * @param array $data Data from json response
     *
     * @throws Exception
     */
    public function __construct(array $data = null)
    {
        $this->raw = [];

        if($data) {
            $this->raw = $data;
        }

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

    /**
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }
}
