<?php

namespace Aboalarm\BannerManagerSdk\Entity;


use Exception;

/**
 * Class Session
 * @package Aboalarm\BannerManagerSdk\Entity
 */
class Session extends Base
{
    /**
     * @var string|null
     */
    private $session;

    /**
     * @var bool|null
     */
    private $external;

    /**
     * @var Campaign|null
     */
    private $campaign;

    /**
     * @var Conversion[]
     */
    private $conversions;

    /**
     * Session constructor.
     *
     * @param array $data Data from json response
     *
     * @throws Exception
     */
    public function __construct(array $data = null)
    {
        $this->conversions = [];

        if ($data) {
            parent::__construct($data);

            $this->session = isset($data['session']) ? $data['session'] : null;
            $this->external = isset($data['external']) ? boolval($data['external']) : null;
            $this->campaign = isset($data['campaign']) ? new Campaign($data['campaign']) : null;

            if (isset($data['conversions'])) {
                foreach ($data['conversions'] as $conversion) {
                    $this->conversions[] = new Conversion($conversion);
                }
            }
        }
    }

    /**
     * @return string|null
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $session
     *
     * @return Session
     */
    public function setSession(string $session): Session
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isExternal()
    {
        return $this->external;
    }

    /**
     * @param bool $external
     *
     * @return Session
     */
    public function setExternal(bool $external): Session
    {
        $this->external = $external;

        return $this;
    }

    /**
     * @return Campaign|null
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param Campaign|null $campaign
     *
     * @return Session
     */
    public function setCampaign(Campaign $campaign): Session
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * @return Conversion[]
     */
    public function getConversions(): array
    {
        return $this->conversions;
    }

    /**
     * @param Conversion|null $conversions
     *
     * @return Session
     */
    public function setConversions(Conversion $conversions)
    {
        $this->conversions = $conversions;

        return $this;
    }

    public function toArray()
    {
        return [
            'session'  => $this->session,
            'external' => $this->external,
        ];
    }
}
