<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class Session
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Session extends Base
{
    /**
     * @var string
     */
    private $session;

    /**
     * @var bool
     */
    private $external;

    /**
     * @var Campaign|null
     */
    private $campaign;

    /**
     * @var null
     */
    private $conversions;

    /**
     * Session constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data)
    {
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

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->external;
    }

    /**
     * @return Campaign|null
     */
    public function getCampaign(): Campaign
    {
        return $this->campaign;
    }

    /**
     * @return null
     */
    public function getConversions()
    {
        return $this->conversions;
    }
}
