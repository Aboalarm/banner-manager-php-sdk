<?php

namespace Aboalarm\BannerManagerSdk\Entity\Traits;

/**
 * Trait ErrorTrait
 *
 * @package Aboalarm\BannerManagerSdk\Entity\Traits
 */
trait ErrorTrait
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array List of fields with errors from validation
     */
    protected $fieldErrors = [];

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

    /**
     * @return array
     */
    public function getFieldErrors()
    {
        return $this->fieldErrors;
    }

    /**
     * @param array $fieldErrors
     *
     * @return ErrorTrait
     */
    public function setFieldErrors(array $fieldErrors)
    {
        $this->fieldErrors = $fieldErrors;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasFields()
    {
        return boolval(count($this->fieldErrors));
    }
}
