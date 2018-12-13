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
     * @var bool
     */
    private $approved = false;

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

    /**
     * Banner constructor.
     *
     * @param array $data Data from json response
     */
    public function __construct(array $data = null)
    {
        $this->bannerPositions = [];
        $this->campaigns = [];

        parent::__construct($data);

        if($data && !isset($data['error'])) {
            $this->name = isset($data['name']) ? $data['name'] : null;
            $this->path = isset($data['path']) ? $data['path'] : null;
            $this->text = isset($data['text']) ? $data['text'] : null;
            $this->link = isset($data['link']) ? $data['link'] : null;
            $this->phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : null;
            $this->previewUrl = isset($data['preview_url']) ? $data['preview_url'] : null;
            $this->views = isset($data['views']) ? $data['views'] : null;
            $this->clicks = isset($data['clicks']) ? $data['clicks'] : null;

            if(isset($data['approved'])){
                $this->approved = boolval($data['approved']);
            }

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

        $data['approved'] = $this->approved;

        return $data;
    }
}
