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
     * @return string
     */
    public function getExternalIdentifier(): string
    {
        return $this->externalIdentifier;
    }
}
