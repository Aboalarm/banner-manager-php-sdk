<?php

namespace aboalarm\BannerManagerSdk\Entity;

use DateTime;

/**
 * Interface EntityInterface
 * @package App\Entity
 */
interface EntityInterface
{
    /**
     * Get id
     *
     * @return string
     */
    public function getId();

    /**
     * Get created at
     *
     * @return DateTime
     */
    public function getCreatedAt();

    /**
     * Get updated at
     *
     * @return DateTime
     */
    public function getUpdatedAt();

    /**
     * Hydrate model to array
     *
     * @return array
     */
    public function toArray();
}
