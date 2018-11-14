<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class Session
 * @package aboalarm\BannerManagerSdk\Entity
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
     * @var Conversion[]|null
     */
    private $conversions;

    /**
     * Session constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            parent::__construct($data);

            $this->session = $data['session'];
            $this->external = boolval($data['external']);

            if ($data['campaign']) {
                $this->campaign = new Session($data['campaign']);
            } else {
                $this->campaign = null;
            }

            if ($data['conversions']) {
                foreach ($data['conversions'] as $conversion) {
                    $this->conversions[] = new Conversion($conversion);
                }
            } else {
                $this->conversions = null;
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
     * @return Conversion[]|null
     */
    public function getConversions()
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
        $data = [];

        if ($this->session) {
            $data['session'] = $this->session;
        }

        if ($this->external) {
            $data['external'] = $this->external;
        }

        if ($this->campaign) {
            $data['campaign'] = [];
            $data['campaign'] = $this->campaign->toArray();
        }

        if ($this->conversions) {
            $data['conversions'] = [];
            foreach ($this->conversions as $conversion) {
                $data['conversions'][] = $conversion->toArray();
            }
        }
    }
}
