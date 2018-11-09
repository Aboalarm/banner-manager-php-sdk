<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 11/9/18
 * Time: 10:45 AM
 */

namespace aboalarm\BannerManagerSdk\Entity;


use DateTime;

/**
 * Class Base
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Base
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
     * Base constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->createdAt = new DateTime($data['created_at']);
        $this->updatedAt = new DateTime($data['updated_at']);
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
}
