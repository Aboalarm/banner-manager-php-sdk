<?php

namespace Aboalarm\BannerManagerSdk\Entity;


use Aboalarm\BannerManagerSdk\Entity\Traits\ErrorTrait;

/**
 * Class Rotation
 *
 * @package Aboalarm\BannerManagerSdk\Entity
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
     * @var bool
     */
    private $thirdPartyTrackingEnabled = false;

    /**
     * @var string|null
     */
    private $thirdPartyEmbedCode;

     /**
     * @var array|null Raw response data
     */
    private $raw;

    /**
     * Banner constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        $this->raw = $data;

        if ($data && !isset($data['error'])) {
            $this->id = isset($data['id']) ? $data['id'] : null;
            $this->name = isset($data['name']) ? $data['name'] : null;
            $this->text = isset($data['text']) ? $data['text'] : null;
            $this->bannerUrl = isset($data['banner_url']) ? $data['banner_url'] : null;
            $this->bannerLink = isset($data['banner_link']) ? $data['banner_link'] : null;
            $this->phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : null;
            $this->gaType = isset($data['ga_type']) ? $data['ga_type'] : null;
            $this->gaKeyword = isset($data['ga_keyword']) ? $data['ga_keyword'] : null;
            $this->isHotline = isset($data['is_hotline']) ? boolval($data['is_hotline']) : false;
            $this->session = isset($data['session']) ? $data['session'] : null;
            $this->positionName = isset($data['position_name']) ? $data['position_name'] : null;
            $this->campaignName = isset($data['campaign_name']) ? $data['campaign_name'] : null;
            $this->width = isset($data['width']) ? $data['width'] : null;
            $this->height = isset($data['height']) ? $data['height'] : null;
            $this->html = isset($data['html']) ? $data['html'] : null;
            $this->size = isset($data['size']) ? $data['size'] : null;
            $this->abTest = isset($data['ab_test']) ? $data['ab_test'] : null;
            $this->isTracking = isset($data['is_tracking']) ? boolval($data['is_tracking']) : false;
            $this->isCommercial = isset($data['is_commercial']) ? boolval($data['is_commercial']) : false;
            $this->thirdPartyTrackingEnabled = isset($data['third_party_tracking_enabled']) ? boolval($data['third_party_tracking_enabled']) : false;
            $this->thirdPartyEmbedCode = isset($data['third_party_embed_code']) ? $data['third_party_embed_code'] : null;
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
     * @return bool
     */
    public function isThirdParty(): bool
    {
        return !empty($this->getThirdPartyEmbedCode());
    }

    /**
     * @return bool
     */
    public function isThirdPartyTrackingEnabled(): bool
    {
        return $this->thirdPartyTrackingEnabled;
    }

    /**
     * @return string|null
     */
    public function getThirdPartyEmbedCode()
    {
        return $this->thirdPartyEmbedCode;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }
}
