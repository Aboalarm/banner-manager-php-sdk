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
     * @return string|null
     */
    public function getId();

    /**
     * Get created at
     *
     * @return DateTime|null
     */
    public function getCreatedAt();

    /**
     * Get updated at
     *
     * @return DateTime|null
     */
    public function getUpdatedAt();

    /**
     * Hydrate model to array
     *
     * @return array
     */
    public function toArray();
}
