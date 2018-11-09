<?php

namespace aboalarm\BannerManagerSdk\Entity;


use DateTime;

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

        if($data['parent']) {
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
     * @return string
     */
    public function getDevice(): string
    {
        return $this->device;
    }

    /**
     * @return string
     */
    public function getViewPort(): string
    {
        return $this->viewPort;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return BannerPosition|null
     */
    public function getParent(): BannerPosition
    {
        return $this->parent;
    }
}
