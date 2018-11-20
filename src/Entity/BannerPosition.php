<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class BannerPosition
 * @package aboalarm\BannerManagerSdk\Entity
 */
class BannerPosition extends Base
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $device;

    /**
     * @var string|null
     */
    private $viewPort;

    /**
     * @var string|null
     */
    private $description;

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
     * @var BannerPosition|null
     */
    private $parent;

    /**
     * @var Banner[]
     */
    private $banners;

    /**
     * BannerPosition constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        $this->banners = [];

        if ($data) {
            parent::__construct($data);

            $this->name = $data['name'];
            $this->device = $data['device'];
            $this->viewPort = $data['view_port'];
            $this->description = $data['description'];
            $this->width = $data['width'];
            $this->height = $data['height'];
            $this->gaType = $data['ga_type'];
            $this->gaKeyword = $data['ga_keyword'];

            if ($data['parent']) {
                $this->parent = new BannerPosition($data['parent']);
            } else {
                $this->parent = null;
            }

            if ($data['banners']) {
                foreach ($data['banners'] as $banner) {
                    $this->banners[] = new Banner($banner);
                }
            }
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
     * @return string|null
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param string|null $device
     *
     * @return BannerPosition
     */
    public function setDevice(string $device = null): BannerPosition
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getViewPort()
    {
        return $this->viewPort;
    }

    /**
     * @param string|null $viewPort
     *
     * @return BannerPosition
     */
    public function setViewPort(string $viewPort = null): BannerPosition
    {
        $this->viewPort = $viewPort;

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
     * @return int|null
     */
    public function getWidth()
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
     * @return int|null
     */
    public function getHeight()
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
     * Get GaType
     *
     * @return null|string
     */
    public function getGaType()
    {
        return $this->gaType;
    }

    /**
     * Set GaType
     *
     * @param null|string $gaType
     *
     * @return $this
     */
    public function setGaType(string $gaType = null)
    {
        $this->gaType = $gaType;

        return $this;
    }

    /**
     * Get GaKeyword
     *
     * @return null|string
     */
    public function getGaKeyword()
    {
        return $this->gaKeyword;
    }

    /**
     * Set GaKeyword
     *
     * @param null|string $gaKeyword
     *
     * @return $this
     */
    public function setGaKeyword(string $gaKeyword = null)
    {
        $this->gaKeyword = $gaKeyword;

        return $this;
    }

    /**
     * @return BannerPosition|null
     */
    public function getParent()
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
     * Get Banners
     *
     * @return Banner[]
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * Set Banners
     *
     * @param Banner[] $banners
     *
     * @return $this
     */
    public function setBanners(array $banners)
    {
        $this->banners = $banners;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        if ($this->name) {
            $data['name'] = $this->name;
        }

        if ($this->device) {
            $data['device'] = $this->device;
        }

        if ($this->viewPort) {
            $data['view_port'] = $this->viewPort;
        }

        if ($this->description) {
            $data['description'] = $this->description;
        }

        if ($this->width) {
            $data['width'] = $this->width;
        }

        if ($this->height) {
            $data['height'] = $this->height;
        }

        if ($this->gaType) {
            $data['ga_type'] = $this->gaType;
        }

        if ($this->gaKeyword) {
            $data['ga_keyword'] = $this->gaKeyword;
        }

        return $data;
    }
}
