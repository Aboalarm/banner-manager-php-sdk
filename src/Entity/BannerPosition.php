<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class BannerPosition
 * @package aboalarm\BannerManagerSdk\Entity
 */
class BannerPosition extends Base
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $device;

    /**
     * @var string
     */
    private $viewPort;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var BannerPosition|null
     */
    private $parent;

    /**
     * BannerPosition constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->name = $data['name'];
        $this->device = $data['device'];
        $this->viewPort = $data['view_port'];
        $this->description = $data['description'];
        $this->width = $data['width'];
        $this->height = $data['height'];

        if ($data['parent']) {
            $this->parent = new BannerPosition($data['parent']);
        } else {
            $this->parent = null;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return BannerPosition
     */
    public function setName(string $name): BannerPosition
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDevice(): string
    {
        return $this->device;
    }

    /**
     * @param string $device
     *
     * @return BannerPosition
     */
    public function setDevice(string $device): BannerPosition
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return string
     */
    public function getViewPort(): string
    {
        return $this->viewPort;
    }

    /**
     * @param string $viewPort
     *
     * @return BannerPosition
     */
    public function setViewPort(string $viewPort): BannerPosition
    {
        $this->viewPort = $viewPort;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return BannerPosition
     */
    public function setDescription(string $description): BannerPosition
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return BannerPosition
     */
    public function setWidth(int $width): BannerPosition
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return BannerPosition
     */
    public function setHeight(int $height): BannerPosition
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return BannerPosition|null
     */
    public function getParent(): BannerPosition
    {
        return $this->parent;
    }

    /**
     * @param BannerPosition|null $parent
     *
     * @return BannerPosition
     */
    public function setParent(BannerPosition $parent): BannerPosition
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return array|void
     */
    public function toArray()
    {
        $data = [];

        $data['name'] = $this->name;
        $data['device'] = $this->device;
        $data['view_port'] = $this->viewPort;
        $data['description'] = $this->description;
        $data['width'] = $this->width;
        $data['height'] = $this->height;

        if ($this->parent) {
            $data['parent'] = [];
            $data['parent'] = $this->parent->toArray();
        } else {
            $data['parent'] = null;
        }
    }
}
