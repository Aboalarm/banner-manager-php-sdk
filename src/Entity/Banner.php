<?php

namespace aboalarm\BannerManagerSdk\Entity;


/**
 * Class Banner
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Banner extends Base
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var string|null
     */
    private $link;

    /**
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @var BannerPosition[]|null
     */
    private $bannerPositions;

    /**
     * Banner constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        if($data) {
            parent::__construct($data);

            $this->name = $data['name'];
            $this->path = $data['path'];
            $this->text = $data['text'];
            $this->link = $data['link'];
            $this->phoneNumber = $data['phone_number'];

            if ($data['banner_positions']) {
                foreach ($data['banner_positions'] as $bannerPosition) {
                    $this->bannerPositions[] = new BannerPosition($bannerPosition);
                }
            } else {
                $this->bannerPositions = null;
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
     * @return Banner
     */
    public function setName(string $name): Banner
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return Banner
     */
    public function setPath(string $path): Banner
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Banner
     */
    public function setText(string $text): Banner
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return Banner
     */
    public function setLink(string $link): Banner
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Banner
     */
    public function setPhoneNumber(string $phoneNumber): Banner
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return BannerPosition[]|null
     */
    public function getBannerPositions()
    {
        return $this->bannerPositions;
    }

    /**
     * @param BannerPosition[]|null $bannerPositions
     *
     * @return Banner
     */
    public function setBannerPositions(array $bannerPositions): Banner
    {
        $this->bannerPositions = $bannerPositions;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];

        if($this->name) {
            $data['name'] = $this->name;
        }

        if($this->path) {
            $data['path'] = $this->path;
        }

        if($this->text) {
            $data['text'] = $this->text;
        }

        if($this->link) {
            $data['link'] = $this->link;
        }

        if($this->phoneNumber) {
            $data['phone_number'] = $this->phoneNumber;
        }

        if ($this->bannerPositions) {
            $data['banner_positions'] = [];
            foreach ($this->bannerPositions as $bannerPosition) {
                $data['banner_positions'][] = $bannerPosition->toArray();
            }
        }

        return $data;
    }
}
