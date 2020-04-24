<?php

namespace Aboalarm\BannerManagerSdk\Entity;

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
     * True if new (not persisted/no ID)
     *
     * @return boolean
     */
    public function isNew();

    /**
     * Hydrate model to array
     *
     * Note: For sub object just send the ID instead of the whole object.
     * For sub object lists just send an array of IDs
     *
     * @return array
     */
    public function toArray();
}
