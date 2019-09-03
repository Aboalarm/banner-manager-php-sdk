<?php

namespace aboalarm\BannerManagerSdk\Entity;


use Exception;

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
    private $description;

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
     * @var bool
     */
    private $approved = false;

    /**
     * @var bool
     */
    private $isTracking = false;

    /**
     * @var bool
     */
    private $isCommercial = false;

    /**
     * @var bool
     */
    private $thirdPartyTrackingEnabled = true;

    /**
     * @var string|null
     */
    private $thirdPartyEmbedCode;

    /**
     * @var string
     */
    private $previewUrl;

    /**
     * @var BannerPosition[]
     */
    private $bannerPositions;

    /**
     * @var Campaign[]
     */
    private $campaigns;

    /**
     * @var int|null
     */
    private $views;

    /**
     * @var int|null
     */
    private $clicks;

    /**
     * @var boolean
     */
    private $forcePut = false;

    private $width = 0;

    private $height = 0;

    /**
     * Banner constructor.
     *
     * @param array $data Data from json response
     *
     * @throws Exception
     */
    public function __construct(array $data = null)
    {
        $this->bannerPositions = [];
        $this->campaigns = [];

        parent::__construct($data);

        if ($data && !isset($data['error'])) {
            $this->name = isset($data['name']) ? $data['name'] : null;
            $this->description = isset($data['description']) ? $data['description'] : null;
            $this->path = isset($data['path']) ? $data['path'] : null;
            $this->text = isset($data['text']) ? $data['text'] : null;
            $this->link = isset($data['link']) ? $data['link'] : null;
            $this->phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : null;
            $this->previewUrl = isset($data['preview_url']) ? $data['preview_url'] : null;
            $this->views = isset($data['views']) ? $data['views'] : null;
            $this->clicks = isset($data['clicks']) ? $data['clicks'] : null;
            $this->approved = isset($data['approved']) ? boolval($data['approved']) : false;
            $this->isTracking = isset($data['is_tracking']) ? boolval($data['is_tracking']) : false;
            $this->isCommercial = isset($data['is_commercial']) ? boolval($data['is_commercial']) : false;
            $this->thirdPartyTrackingEnabled = isset($data['third_party_tracking_enabled']) ? boolval($data['third_party_tracking_enabled']) : true;
            $this->thirdPartyEmbedCode = isset($data['third_party_embed_code']) ? $data['third_party_embed_code'] : null;
            $this->width = isset($data['width']) ? (int) $data['width'] : 0;
            $this->height = isset($data['height']) ? (int) $data['height'] : 0;

            if (isset($data['banner_positions']) && is_array($data['banner_positions'])) {
                foreach ($data['banner_positions'] as $bannerPosition) {
                    $this->bannerPositions[] = new BannerPosition($bannerPosition);
                }
            }

            if (isset($data['campaigns']) && is_array($data['campaigns'])) {
                foreach ($data['campaigns'] as $campaign) {
                    $this->campaigns[] = new Campaign($campaign);
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return Banner
     */
    public function setDescription(string $description): Banner
    {
        $this->description = $description;

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
     * @return bool
     */
    public function getApproved(): bool
    {
        return $this->approved;
    }

    /**
     * @param bool $approved
     *
     * @return Banner
     */
    public function setApproved(bool $approved): Banner
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTracking(): bool
    {
        return $this->isTracking;
    }

    /**
     * @param bool $isTracking
     *
     * @return Banner
     */
    public function setIsTracking(bool $isTracking): Banner
    {
        $this->isTracking = $isTracking;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCommercial(): bool
    {
        return $this->isCommercial;
    }

    /**
     * @param bool $isCommercial
     *
     * @return Banner
     */
    public function setIsCommercial(bool $isCommercial): Banner
    {
        $this->isCommercial = $isCommercial;

        return $this;
    }

    /**
     * @return bool
     */
    public function isThirdParty(): bool
    {
        return !empty($this->getThirdPartyEmbedCode());
    }

    /**
     * @param bool $isThirdParty
     *
     * @return Banner
     */
    public function setIsThirdParty(bool $isThirdParty): Banner
    {
        $this->isThirdParty = $isThirdParty;

        return $this;
    }

    /**
     * @return bool
     */
    public function isThirdPartyTrackingEnabled(): bool
    {
        return $this->thirdPartyTrackingEnabled;
    }

    /**
     * @param bool $thirdPartyTrackingEnabled
     *
     * @return Banner
     */
    public function setThirdPartyTrackingEnabled(bool $thirdPartyTrackingEnabled): Banner
    {
        $this->thirdPartyTrackingEnabled = $thirdPartyTrackingEnabled;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThirdPartyEmbedCode()
    {
        return $this->thirdPartyEmbedCode;
    }

    /**
     * @param string|null $thirdPartyEmbedCode
     *
     * @return Banner
     */
    public function setThirdPartyEmbedCode($thirdPartyEmbedCode): Banner
    {
        $this->thirdPartyEmbedCode = $thirdPartyEmbedCode;

        return $this;
    }

    /**
     * Get PreviewUrl
     *
     * @return string|null
     */
    public function getPreviewUrl()
    {
        return $this->previewUrl;
    }

    /**
     * Set PreviewUrl
     *
     * @param string $previewUrl
     *
     * @return $this
     */
    public function setPreviewUrl(string $previewUrl)
    {
        $this->previewUrl = $previewUrl;

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
     * Get Campaigns
     *
     * @return Campaign[]
     */
    public function getCampaigns(): array
    {
        return $this->campaigns;
    }

    /**
     * Set Campaigns
     *
     * @param Campaign[] $campaigns
     *
     * @return $this
     */
    public function setCampaigns(array $campaigns)
    {
        $this->campaigns = $campaigns;

        return $this;
    }

    /**
     * Get Views
     *
     * @return int|null
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Get Clicks
     *
     * @return int|null
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Check if we want to force updating this banner
     *
     * @return bool
     */
    public function getForcePut(): bool
    {
        return $this->forcePut;
    }

    /**
     * Set if we want to force update this banner
     *
     * @param bool $forcePut
     *
     * @return Banner
     */
    public function setForcePut(bool $forcePut): Banner
    {
        $this->forcePut = $forcePut;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    public function getBannerOrientation()
    {
        if ($this->width === 0 || $this->height === 0) {
            return 'incorrect dimensions';
        }

        if ($this->width === $this->height) {
            return 'square';
        }

        return ($this->width > $this->height) ? 'horizontal' : 'vertical';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'                         => $this->name,
            'description'                  => $this->description,
            'path'                         => $this->path,
            'text'                         => $this->text,
            'link'                         => $this->link,
            'phone_number'                 => $this->phoneNumber,
            'approved'                     => $this->approved,
            'is_tracking'                  => $this->isTracking,
            'is_commercial'                => $this->isCommercial,
            'third_party_tracking_enabled' => $this->thirdPartyEmbedCode ? $this->thirdPartyTrackingEnabled : false,
            'third_party_embed_code'       => $this->thirdPartyEmbedCode,
        ];
    }
}
