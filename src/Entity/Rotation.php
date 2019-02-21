<?php

namespace aboalarm\BannerManagerSdk\Entity;


use aboalarm\BannerManagerSdk\Entity\Traits\ErrorTrait;

/**
 * Class Rotation
 *
 * @package aboalarm\BannerManagerSdk\Entity
 */
class Rotation
{
    use ErrorTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var string|null
     */
    private $text = null;

    /**
     * @var string|null
     */
    private $bannerUrl;

    /**
     * @var string|null
     */
    private $bannerLink = null;

    /**
     * @var string|null
     */
    private $phoneNumber = null;

    /**
     * @var string|null
     */
    private $gaType = null;

    /**
     * @var string|null
     */
    private $gaKeyword = null;

    /**
     * @var boolean
     */
    private $isHotline;

    /**
     * @var string
     */
    private $session = null;

    /**
     * @var string
     */
    private $positionName;

    /**
     * @var string
     */
    private $campaignName;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $size;

    /**
     * @var string|null
     */
    private $html;

    /**
     * @var string|null
     */
    private $abTest;

    /**
     * @var bool
     */
    private $isTracking;

    /**
     * @var bool
     */
    private $isCommercial;


    /**
     * Banner constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        if($data) {
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->text = $data['text'];
            $this->bannerUrl = $data['banner_url'];
            $this->bannerLink = $data['banner_link'];
            $this->phoneNumber = $data['phone_number'];
            $this->gaType = $data['ga_type'];
            $this->gaKeyword = $data['ga_keyword'];
            $this->isHotline = boolval($data['is_hotline']);
            $this->session = $data['session'];
            $this->positionName = $data['position_name'];
            $this->campaignName = $data['campaign_name'];
            $this->width = $data['width'];
            $this->height = $data['height'];
            $this->html = $data['html'];
            $this->size = $data['size'];
            $this->abTest = $data['ab_test'];
            $this->isTracking = boolval($data['is_tracking']);
            $this->isCommercial = boolval($data['is_commercial']);
        }
    }

    /**
     * Get Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Text
     *
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get BannerUrl
     *
     * @return null|string
     */
    public function getBannerUrl()
    {
        return $this->bannerUrl;
    }

    /**
     * Set BannerUrl
     *
     * @param null|string $bannerUrl
     *
     * @return $this
     */
    public function setBannerUrl(string $bannerUrl)
    {
        $this->bannerUrl = $bannerUrl;

        return $this;
    }

    /**
     * Get BannerLink
     *
     * @return null|string
     */
    public function getBannerLink()
    {
        return $this->bannerLink;
    }

    /**
     * Set BannerLink
     *
     * @param null|string $bannerLink
     *
     * @return $this
     */
    public function setBannerLink(string $bannerLink)
    {
        $this->bannerLink = $bannerLink;
        return $this;
    }

    /**
     * Get PhoneNumber
     *
     * @return null|string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
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
     * Get GaKeyword
     *
     * @return null|string
     */
    public function getGaKeyword()
    {
        return $this->gaKeyword;
    }

    /**
     * Get isHotline
     *
     * @return bool
     */
    public function isHotline(): bool
    {
        return $this->isHotline;
    }

    /**
     * Get Session
     *
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }
    /**
     * Get PositionName
     *
     * @return string
     */
    public function getPositionName()
    {
        return $this->positionName;
    }

    /**
     * Get CampaignName
     *
     * @return string
     */
    public function getCampaignName()
    {
        return $this->campaignName;
    }

    /**
     * Get Html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Get Width
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Get Height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return string|null
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string|null
     */
    public function getAbTest(): string
    {
        return $this->abTest;
    }

    /**
     * @return bool
     */
    public function isTracking(): bool
    {
        return $this->isTracking;
    }

    /**
     * @return bool
     */
    public function isCommercial(): bool
    {
        return $this->isCommercial;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
