<?php

namespace aboalarm\BannerManagerSdk\Entity;


use Exception;

/**
 * Class Conversion
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Conversion extends Base
{
    const TYPE_CANCELLATION = 'cancellation';
    const TYPE_PDF_DOWNLOAD = 'pdf_download';

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
     *
     * @throws Exception
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        if ($data && !isset($data['error'])) {
            $this->type = isset($data['type']) ? $data['type'] : null;
            $this->externalIdentifier = isset($data['external_identifier']) ? $data['external_identifier'] : null;
            $this->session = isset($data['session']) ? new Session($data['session']) : null;
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
    public function getSession()
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
        return [
            'type'                => $this->type,
            'external_identifier' => $this->externalIdentifier,
            'session'             => ($this->session instanceof Session) ? $this->session->getId() : null,
        ];
    }
}
