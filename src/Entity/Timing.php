<?php

namespace aboalarm\BannerManagerSdk\Entity;


use Exception;

/**
 * Class Timing
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Timing extends Base
{
    /**
     * Possible type values
     */
    const TYPE_WORKDAYS = 'workdays';
    const TYPE_WEEKENDS = 'weekends';
    const TYPE_MONDAY = 'Mon';
    const TYPE_TUESDAY = 'Tue';
    const TYPE_WEDNESDAY = 'Wed';
    const TYPE_THURSDAY = 'Thu';
    const TYPE_FRIDAY = 'Fri';
    const TYPE_SATURDAY = 'Sat';
    const TYPE_SUNDAY = 'Sun';

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
     * @var bool|null
     */
    private $isHotline;

    /**
     * @var Campaign|null
     */
    private $campaign;

    /**
     * @var ABTest|null
     */
    private $abTest;

    /**
     * Banner constructor.
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
            $this->dateFrom = isset($data['date_from']) ? $data['date_from'] : null;
            $this->dateUntil = isset($data['date_until']) ? $data['date_until'] : null;
            $this->timeFrom = isset($data['time_from']) ? $data['time_from'] : null;
            $this->timeUntil = isset($data['time_until']) ? $data['time_until'] : null;
            $this->isHotline = isset($data['is_hotline']) ? $data['is_hotline'] : null;
            $this->campaign = isset($data['campaign']) ? new Campaign($data['campaign']) : null;
            $this->abTest = isset($data['ab_test']) ? new ABTest($data['ab_test']) : null;
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
     * @param string|null $type
     *
     * @return Timing
     */
    public function setType(string $type = null): Timing
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
     * @param string|null $dateFrom
     *
     * @return Timing
     */
    public function setDateFrom(string $dateFrom = null): Timing
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
     * @param string|null $dateUntil
     *
     * @return Timing
     */
    public function setDateUntil(string $dateUntil = null): Timing
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
     * @param string|null $timeFrom
     *
     * @return Timing
     */
    public function setTimeFrom(string $timeFrom = null): Timing
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
     * @param string|null $timeUntil
     *
     * @return Timing
     */
    public function setTimeUntil(string $timeUntil = null): Timing
    {
        $this->timeUntil = $timeUntil;

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
     * @return Timing
     */
    public function setIsHotline(bool $isHotline = false): Timing
    {
        $this->isHotline = $isHotline;

        return $this;
    }

    /**
     * Get Campaign
     *
     * @return Campaign|null
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * Set Campaign
     *
     * @param Campaign|null $campaign
     *
     * @return $this
     */
    public function setCampaign(Campaign $campaign = null)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get AbTest
     *
     * @return ABTest|null
     */
    public function getAbTest()
    {
        return $this->abTest;
    }

    /**
     * Set AbTest
     *
     * @param ABTest|null $abTest
     *
     * @return $this
     */
    public function setAbTest(ABTest $abTest = null)
    {
        $this->abTest = $abTest;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'type'       => $this->type,
            'date_from'  => $this->dateFrom,
            'date_until' => $this->dateUntil,
            'time_from'  => $this->timeFrom,
            'time_until' => $this->timeUntil,
            'is_hotline' => $this->isHotline,
        ];


    }

    /**
     * Type map
     *
     * @return array
     */
    static public function getTypeMapping()
    {
        return [
            ''                     => 'Immer',
            static::TYPE_WORKDAYS  => 'Werktags (Mo - Fr)',
            static::TYPE_WEEKENDS  => 'Wochende (Sa & So)',
            static::TYPE_MONDAY    => 'Montags',
            static::TYPE_TUESDAY   => 'Dienstags',
            static::TYPE_WEDNESDAY => 'Mittwochs',
            static::TYPE_THURSDAY  => 'Donnerstags',
            static::TYPE_FRIDAY    => 'Freitags',
            static::TYPE_SATURDAY  => 'Samstags',
            static::TYPE_SUNDAY    => 'Sonntags',
        ];
    }
}
