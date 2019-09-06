<?php

namespace aboalarm\BannerManagerSdk\Entity;


use Exception;

/**
 * Class PositionTemplate
 * @package aboalarm\BannerManagerSdk\Entity
 */
class PositionTemplate extends Base
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $portal;

    /**
     * @var string|null
     */
    private $dynamicKey;

    /**
     * @var string|null
     */
    private $device;

    /**
     * @var string|null
     */
    private $page;

    /**
     * @var string|null
     */
    private $section;

    /**
     * @var string|null
     */
    private $position;

    /**
     * @var int|null
     */
    private $width;

    /**
     * @var int|null
     */
    private $height;

    /**
     * @var string|null
     */
    private $gaType;

    /**
     * @var string|null
     */
    private $gaKeyword;

    /**
     * @var bool|null
     */
    private $exactMatch;

    /**
     * @var bool|null
     */
    private $orientationMatch;

    /**
     * BannerPosition constructor.
     *
     * @param array $data Data from json response
     *
     * @throws Exception
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        if ($data && !isset($data['error'])) {
            $this->name = isset($data['name']) ? $data['name'] : null;
            $this->description = isset($data['description']) ? $data['description'] : null;
            $this->portal = isset($data['portal']) ? $data['portal'] : null;
            $this->dynamicKey = isset($data['dynamic_key']) ? $data['dynamic_key'] : null;
            $this->device = isset($data['device']) ? $data['device'] : null;
            $this->page = isset($data['page']) ? $data['page'] : null;
            $this->section = isset($data['section']) ? $data['section'] : null;
            $this->position = isset($data['position']) ? $data['position'] : null;
            $this->width = isset($data['width']) ? (int) $data['width'] : null;
            $this->height = isset($data['height']) ? (int) $data['height'] : null;
            $this->gaType = isset($data['ga_type']) ? $data['ga_type'] : null;
            $this->gaKeyword = isset($data['ga_keyword']) ? $data['ga_keyword'] : null;
            $this->exactMatch = isset($data['exact_match']) ? (bool) $data['exact_match'] : null;
            $this->orientationMatch = isset($data['orientation_match']) ? (bool) $data['orientation_match'] : null;
        }
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return PositionTemplate
     */
    public function setName(string $name): PositionTemplate
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return PositionTemplate
     */
    public function setDescription(string $description): PositionTemplate
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * @param string|null $portal
     *
     * @return PositionTemplate
     */
    public function setPortal(string $portal): PositionTemplate
    {
        $this->portal = $portal;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDynamicKey()
    {
        return $this->dynamicKey;
    }

    /**
     * @param string|null $dynamicKey
     *
     * @return PositionTemplate
     */
    public function setDynamicKey($dynamicKey): PositionTemplate
    {
        $this->dynamicKey = $dynamicKey;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param string|null $device
     *
     * @return PositionTemplate
     */
    public function setDevice(string $device): PositionTemplate
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param string|null $page
     *
     * @return PositionTemplate
     */
    public function setPage(string $page): PositionTemplate
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string|null $section
     *
     * @return PositionTemplate
     */
    public function setSection(string $section): PositionTemplate
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string|null $position
     *
     * @return PositionTemplate
     */
    public function setPosition(string $position): PositionTemplate
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     *
     * @return PositionTemplate
     */
    public function setWidth(int $width): PositionTemplate
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     *
     * @return PositionTemplate
     */
    public function setHeight(int $height): PositionTemplate
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGaType()
    {
        return $this->gaType;
    }

    /**
     * @param string|null $gaType
     *
     * @return PositionTemplate
     */
    public function setGaType(string $gaType): PositionTemplate
    {
        $this->gaType = $gaType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGaKeyword()
    {
        return $this->gaKeyword;
    }

    /**
     * @param string|null $gaKeyword
     *
     * @return PositionTemplate
     */
    public function setGaKeyword(string $gaKeyword): PositionTemplate
    {
        $this->gaKeyword = $gaKeyword;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getExactMatch(): bool
    {
        return $this->exactMatch;
    }

    /**
     * @return bool|null
     */
    public function getOrientationMatch(): bool
    {
        return $this->orientationMatch;
    }

    /**
     * @return bool
     */
    public function isStatic()
    {
        return $this->dynamicKey === null;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'portal'      => $this->portal,
            'dynamic_key' => $this->dynamicKey,
            'device'      => $this->device,
            'page'        => $this->page,
            'section'     => $this->section,
            'position'    => $this->position,
            'width'       => $this->width,
            'height'      => $this->height,
            'ga_type'     => $this->gaType,
            'ga_keyword'  => $this->gaKeyword,
        ];
    }
}
