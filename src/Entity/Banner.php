<?php

namespace aboalarm\BannerManagerSdk\Entity;


use DateTime;

/**
 * Class Banner
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Banner extends Base
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
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
    public function __construct(array $data)
    {
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
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return BannerPosition[]|null
     */
    public function getBannerPositions(): array
    {
        return $this->bannerPositions;
    }
}
