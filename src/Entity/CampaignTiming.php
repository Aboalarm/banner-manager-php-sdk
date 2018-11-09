<?php

namespace aboalarm\BannerManagerSdk\Entity;


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
     * @param string $type
     *
     * @return CampaignTiming
     */
    public function setType(string $type): CampaignTiming
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @param string $dateFrom
     *
     * @return CampaignTiming
     */
    public function setDateFrom(string $dateFrom): CampaignTiming
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateUntil(): string
    {
        return $this->dateUntil;
    }

    /**
     * @param string $dateUntil
     *
     * @return CampaignTiming
     */
    public function setDateUntil(string $dateUntil): CampaignTiming
    {
        $this->dateUntil = $dateUntil;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeFrom(): string
    {
        return $this->timeFrom;
    }

    /**
     * @param string $timeFrom
     *
     * @return CampaignTiming
     */
    public function setTimeFrom(string $timeFrom): CampaignTiming
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeUntil(): string
    {
        return $this->timeUntil;
    }

    /**
     * @param string $timeUntil
     *
     * @return CampaignTiming
     */
    public function setTimeUntil(string $timeUntil): CampaignTiming
    {
        $this->timeUntil = $timeUntil;

        return $this;
    }

    /**
     * @return string
     */
    public function getWeekday(): string
    {
        return $this->weekday;
    }

    /**
     * @param string $weekday
     *
     * @return CampaignTiming
     */
    public function setWeekday(string $weekday): CampaignTiming
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHotline(): bool
    {
        return $this->isHotline;
    }

    /**
     * @param bool $isHotline
     *
     * @return CampaignTiming
     */
    public function setIsHotline(bool $isHotline): CampaignTiming
    {
        $this->isHotline = $isHotline;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        $data['type'] = $this->type;
        $data['date_from'] = $this->dateFrom;
        $data['date_until'] = $this->dateUntil;
        $data['time_from'] = $this->timeFrom;
        $data['time_until'] = $this->timeUntil;
        $data['weekday'] = $this->weekday;
        $data['is_hotline'] = $this->isHotline;

        return $data;
    }
}
