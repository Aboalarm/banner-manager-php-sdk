<?php

namespace aboalarm\BannerManagerSdk\Entity;


use DateTime;

/**
 * Class CampaignTiming
 * @package aboalarm\BannerManagerSdk\Entity
 */
class CampaignTiming extends Base
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $dateFrom;

    /**
     * @var string
     */
    private $dateUntil;

    /**
     * @var string
     */
    private $timeFrom;

    /**
     * @var string
     */
    private $timeUntil;

    /**
     * @var string
     */
    private $weekday;

    /**
     * @var bool
     */
    private $isHotline;

    /**
     * Banner constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->type = $data['type'];
        $this->dateFrom = $data['date_from'];
        $this->dateUntil = $data['date_until'];
        $this->timeFrom = $data['time_from'];
        $this->timeUntil = $data['time_until'];
        $this->weekday = $data['weekday'];
        $this->isHotline = boolval($data['is_hotline']);
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
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateUntil(): string
    {
        return $this->dateUntil;
    }

    /**
     * @return string
     */
    public function getTimeFrom(): string
    {
        return $this->timeFrom;
    }

    /**
     * @return string
     */
    public function getTimeUntil(): string
    {
        return $this->timeUntil;
    }

    /**
     * @return string
     */
    public function getWeekday(): string
    {
        return $this->weekday;
    }

    /**
     * @return bool
     */
    public function isHotline(): bool
    {
        return $this->isHotline;
    }
}
