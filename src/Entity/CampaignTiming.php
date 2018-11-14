<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class CampaignTiming
 * @package aboalarm\BannerManagerSdk\Entity
 */
class CampaignTiming extends Base
{
    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $dateFrom;

    /**
     * @var string|null
     */
    private $dateUntil;

    /**
     * @var string|null
     */
    private $timeFrom;

    /**
     * @var string|null
     */
    private $timeUntil;

    /**
     * @var string|null
     */
    private $weekday;

    /**
     * @var bool|null
     */
    private $isHotline;

    /**
     * Banner constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            parent::__construct($data);

            $this->type = $data['type'];
            $this->dateFrom = $data['date_from'];
            $this->dateUntil = $data['date_until'];
            $this->timeFrom = $data['time_from'];
            $this->timeUntil = $data['time_until'];
            $this->weekday = $data['weekday'];
            $this->isHotline = boolval($data['is_hotline']);
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
     * @return CampaignTiming
     */
    public function setType(string $type): CampaignTiming
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateFrom()
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
     * @return string|null
     */
    public function getDateUntil()
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
     * @return string|null
     */
    public function getTimeFrom()
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
     * @return string|null
     */
    public function getTimeUntil()
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
     * @return string|null
     */
    public function getWeekday()
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
     * @return bool|null
     */
    public function isHotline()
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

        if ($this->type) {
            $data['type'] = $this->type;
        }

        if ($this->dateFrom) {
            $data['date_from'] = $this->dateFrom;
        }

        if ($this->dateUntil) {
            $data['date_until'] = $this->dateUntil;
        }

        if ($this->timeFrom) {
            $data['time_from'] = $this->timeFrom;
        }

        if ($this->timeUntil) {
            $data['time_until'] = $this->timeUntil;
        }

        if ($this->weekday) {
            $data['weekday'] = $this->weekday;
        }

        if ($this->isHotline) {
            $data['is_hotline'] = $this->isHotline;
        }

        return $data;
    }
}
