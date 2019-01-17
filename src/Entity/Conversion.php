<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class Conversion
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Conversion extends Base
{
    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $externalIdentifier;

    /**
     * @var Session|null
     */
    private $session;

    /**
     * Conversion constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        if($data && !isset($data['error'])) {
            $this->type = $data['type'];
            $this->externalIdentifier = $data['external_identifier'];
            $this->session = $data['session'] ? new Session($data['session']) : null;
        }
    }

    /**
     * @return string|null
     */
    public function getType()
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
     * @return string|null
     */
    public function getExternalIdentifier()
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
     * @return Session|null
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @param Session|null $session
     *
     * @return Conversion
     */
    public function setSession(Session $session): Conversion
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        if ($this->type) {
            $data['type'] = $this->type;
        }

        if ($this->externalIdentifier) {
            $data['external_identifier'] = $this->externalIdentifier;
        }

        if ($this->session) {
            $data['session'] = $this->session->getId();
        }

        return $data;
    }
}
