<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class Conversion
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Conversion extends Base
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $externalIdentifier;

    /**
     * Conversion constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->type = $data['type'];
        $this->externalIdentifier = $data['external_identifier'];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Conversion
     */
    public function setType(string $type): Conversion
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalIdentifier(): string
    {
        return $this->externalIdentifier;
    }

    /**
     * @param string $externalIdentifier
     *
     * @return Conversion
     */
    public function setExternalIdentifier(string $externalIdentifier): Conversion
    {
        $this->externalIdentifier = $externalIdentifier;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        $data['type'] = $this->type;
        $data['external_identifier'] = $this->externalIdentifier;

        return $data;
    }
}
