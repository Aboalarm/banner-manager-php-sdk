<?php

namespace aboalarm\BannerManagerSdk\Entity\Traits;

/**
 * Trait ErrorTrait
 *
 * @package aboalarm\BannerManagerSdk\Entity\Traits
 */
trait ErrorTrait
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Get Errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set Errors
     *
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return boolval(count($this->errors));
    }
}