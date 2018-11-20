<?php

namespace aboalarm\BannerManagerSdk\BannerSDK;

use aboalarm\BannerManagerSdk\Entity\ABTest;
use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\BannerPosition;
use aboalarm\BannerManagerSdk\Entity\Base;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Entity\Rotation;
use aboalarm\BannerManagerSdk\Entity\Timing;
use aboalarm\BannerManagerSdk\Exception\BannerManagerException;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use Exception;
use aboalarm\BannerManagerSdk\Pagination\PaginationOptions;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\UploadedFile;

/**
 * Class Client
 * @package aboalarm\BannerManagerSdk\BannerSDK
 */
class Client
{

    /**
     * The HTTP client instance.
     *
     * @var Http
     */
    private $http;

    /**
     * Crate a new client instance.
     *
     * The API uses basic authentication. The username and password are passed
     * to the `auth` option of Guzzle HTTP client. This way they don't have to
     * be stored inside the class, neither be manually passed to all API
     * requests.
     *
     * @param string $baseUri The API base uri
     * @param string $username The API user username.
     * @param string $password The API user password.
     * @param string|null $proxyUri The Proxy URI if API is behind a proxy
     */
    public function __construct($baseUri, $username, $password, $proxyUri = null)
    {
        $this->http = new Http(
            [
                'base_uri' => $baseUri,
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'auth' => [
                    $username,
                    $password,
                ],
                'proxy_uri' => $proxyUri
            ]
        );

    }

    /**
     * Get base URI
     *
     * @return string
     */
    public function getBaseUri()
    {
        $config = $this->http->getConfig();

        return isset($config['base_uri']) ? $config['base_uri'] : null;
    }

    /**
     * Get proxy URI
     *
     * @return string|null
     */
    public function getProxyUri()
    {
        $config = $this->http->getConfig();

        return (isset($config['proxy_uri']) && $config['proxy_uri']) ? $config['proxy_uri'] : null;
    }

    /**
     * Get all banners.
     *
     * @param PaginationOptions $options
     *
     * @return PaginatedCollection Banner collection.
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getBanners(PaginationOptions $options)
    {
        $queryParams = [];

        $queryParams['page'] = $options->getPage();
        $queryParams['limit'] = $options->getLimit();

        if ($options->getFilter()) {
            $queryParams['filter'] = $options->getFilter();
        }

        if ($options->getSort()) {
            $queryParams['sort'] = $options->getSort();
        }

        $data = $this->doGetRequest('/api/banners', $queryParams);

        $banners = [];

        if ($data['items']) {
            foreach ($data['items'] as $datum) {
                $banners[] = new Banner($datum);
            }
        }

        return new PaginatedCollection(
            $banners,
            $data['count'],
            $data['total'],
            $data['page'],
            $data['total_pages'],
            $data['pages']
        );
    }

    /**
     * Get single banner by id
     *
     * @param string $identifier Banner identifier
     *
     * @return Banner
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getBanner(string $identifier)
    {
        $data = $this->doGetRequest('/api/banners/'.$identifier);

        if (!empty($data)) {
            $banner = new Banner($data);

            if($this->getProxyUri()) {
                $banner->setPreviewUrl(
                    str_replace($this->getBaseUri(), $this->getProxyUri(), $banner->getPreviewUrl())
                );
            }

            return $banner;
        }

        throw new BannerManagerException("Error reading banner data");
    }

    /**
     * @param Banner $banner
     *
     * @return Banner
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postBanner(Banner $banner)
    {
        $data = $this->doPostRequest('/api/banners', $banner->toArray());

        return new Banner($data);
    }

    /**
     * Upload banner
     *
     * @param Banner       $banner
     * @param UploadedFile $file
     *
     * @return Banner
     *
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function uploadBanner(Banner $banner, UploadedFile $file)
    {
        $multipart = [
            'name' => 'image',
            'contents' => fopen($file->getRealPath(), 'r'),
            'filename' => $file->getClientOriginalName(),
        ];

        $data = $this->doMultipartRequest(
            '/api/banners/'.$banner->getId().'/upload',
            [
                $multipart,
            ]
        );

        if (isset($data[0]) && $data[0] === 'OK') {
            return $this->getBanner($banner->getId());
        }
    }


    /**
     * @param Banner $banner
     *
     * @return Banner
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function putBanner(Banner $banner)
    {
        $uri = '/api/banners/'.$banner->getId();
        $data = $this->doPutRequest($uri, $banner);

        return new Banner($data);
    }

    /**
     * @param string $identifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function deleteBanner(string $identifier)
    {
        $uri = '/api/banners/'.$identifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * Post multiple campaigns to be assigned to a banner
     *
     * @param string $identifier          Banner identifier
     * @param array  $campaignIdentifiers Array with campaign identifiers to add
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postBannerCampaigns(string $identifier, array $campaignIdentifiers)
    {
        $uri = '/api/banners/'.$identifier.'/campaigns';
        $formParams = ['campaigns' => $campaignIdentifiers];

        return $this->doPostRequest($uri, $formParams);
    }

    /**
     * Remove a campaign from banner
     *
     * @param string $bannerIdentifier
     * @param string $campaignIdentifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function removeCampaignFromBanner(string $bannerIdentifier, string $campaignIdentifier)
    {
        $uri = '/api/banners/'.$bannerIdentifier.'/campaigns/'.$campaignIdentifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * Post multiple banner positions to be assigned to a banner
     *
     * @param string $identifier          Banner identifier
     * @param array  $positionIdentifiers Array with position identifiers to add
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postBannerBannerPositions(string $identifier, array $positionIdentifiers)
    {
        $uri = '/api/banners/'.$identifier.'/banner-positions';
        $formParams = ['positions' => $positionIdentifiers];

        return $this->doPostRequest($uri, $formParams);
    }

    /**
     * Remove a banner position from banner
     *
     * @param string $bannerIdentifier
     * @param string $positionIdentifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function removeBannerPositionFromBanner(
        string $bannerIdentifier,
        string $positionIdentifier
    ) {
        $uri = '/api/banners/'.$bannerIdentifier.'/banner-positions/'.$positionIdentifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * Get all campaigns.
     *
     * @param PaginationOptions $options
     *
     * @return PaginatedCollection Campaign collection.
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getCampaigns(PaginationOptions $options)
    {
        $queryParams = [];

        $queryParams['page'] = $options->getPage();
        $queryParams['limit'] = $options->getLimit();

        if ($options->getFilter()) {
            $queryParams['filter'] = $options->getFilter();
        }

        if ($options->getSort()) {
            $queryParams['sort'] = $options->getSort();
        }

        $data = $this->doGetRequest('/api/campaigns', $queryParams);

        $campaigns = [];

        if ($data['items']) {
            foreach ($data['items'] as $datum) {
                $campaigns[] = new Campaign($datum);
            }
        }

        return new PaginatedCollection(
            $campaigns,
            $data['count'],
            $data['total'],
            $data['page'],
            $data['total_pages'],
            $data['pages']
        );
    }

    /**
     * Get single campaign by id
     *
     * @param string $identifier Campaign identifier
     *
     * @return Campaign
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getCampaign(string $identifier)
    {
        $data = $this->doGetRequest('/api/campaigns/'.$identifier);

        if (!empty($data)) {
            return new Campaign($data);
        }

        throw new BannerManagerException("Error reading campaign data");
    }

    /**
     * @param Campaign $campaign
     *
     * @return Campaign
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postCampaign(Campaign $campaign)
    {
        $data = $this->doPostRequest('/api/campaigns', $campaign->toArray());

        return new Campaign($data);
    }

    /**
     * @param Campaign $campaign
     *
     * @return Campaign
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function putCampaign(Campaign $campaign)
    {
        $uri = '/api/campaigns/'.$campaign->getId();
        $data = $this->doPutRequest($uri, $campaign);

        return new Campaign($data);
    }

    /**
     * @param string $identifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function deleteCampaign(string $identifier)
    {
        $uri = '/api/campaigns/'.$identifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * Post multiple banners to be assigned to a campaign
     *
     * @param string $identifier        Campaign identifier
     * @param array  $bannerIdentifiers Array with banner identifiers to add
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postCampaignBanners(string $identifier, array $bannerIdentifiers)
    {
        $uri = '/api/campaigns/'.$identifier.'/banners';
        $formParams = ['banners' => $bannerIdentifiers];

        return $this->doPostRequest($uri, $formParams);
    }

    /**
     * Remove a banner from campaign
     *
     * @param string $campaignIdentifier
     * @param string $bannerIdentifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function removeBannerFromCampaign(string $campaignIdentifier, string $bannerIdentifier)
    {
        $uri = '/api/campaigns/'.$campaignIdentifier.'/banners/'.$bannerIdentifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * @param string $campaignIdentifier
     * @param Timing $timing
     *
     * @return Timing
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postCampaignTiming(string $campaignIdentifier, Timing $timing)
    {
        $uri = '/api/campaigns/'.$campaignIdentifier.'/timings';
        $data = $this->doPostRequest($uri, $timing->toArray());

        return new Timing($data);
    }

    /**
     * @param string $campaignIdentifier
     * @param Timing $timing
     *
     * @return Timing
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function putCampaignTiming(string $campaignIdentifier, Timing $timing)
    {
        $uri = '/api/campaigns/'.$campaignIdentifier.'/timings/'.$timing->getId();
        $data = $this->doPutRequest($uri, $timing);

        return new Timing($data);
    }

    /**
     * @param string $campaignIdentifier
     * @param Timing $timing
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function deleteCampaignTiming(string $campaignIdentifier, Timing $timing)
    {
        $uri = '/api/campaigns/'.$campaignIdentifier.'/timings/'.$timing->getId();

        return $this->doDeleteRequest($uri);
    }

    /**
     * Get all banner positions.
     *
     * @param PaginationOptions $options
     *
     * @return PaginatedCollection BannerPosition collection.
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getBannerPositions(PaginationOptions $options)
    {
        $queryParams = [];

        $queryParams['page'] = $options->getPage();
        $queryParams['limit'] = $options->getLimit();

        if ($options->getFilter()) {
            $queryParams['filter'] = $options->getFilter();
        }

        if ($options->getSort()) {
            $queryParams['sort'] = $options->getSort();
        }

        $data = $this->doGetRequest('/api/banner-positions', $queryParams);

        $bannerPositions = [];

        if ($data['items']) {
            foreach ($data['items'] as $datum) {
                $bannerPositions[] = new BannerPosition($datum);
            }
        }

        return new PaginatedCollection(
            $bannerPositions,
            $data['count'],
            $data['total'],
            $data['page'],
            $data['total_pages'],
            $data['pages']
        );
    }

    /**
     * Get single campaign by id
     *
     * @param string $identifier BannerPosition identifier
     *
     * @return BannerPosition
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getBannerPosition(string $identifier)
    {
        $data = $this->doGetRequest('/api/banner-positions/'.$identifier);

        if (!empty($data)) {
            return new BannerPosition($data);
        }

        throw new BannerManagerException("Error reading banner position data");
    }

    /**
     * @param BannerPosition $bannerPosition
     *
     * @return BannerPosition
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postBannerPosition(BannerPosition $bannerPosition)
    {
        $data = $this->doPostRequest('/api/banner-positions', $bannerPosition->toArray());

        return new BannerPosition($data);
    }

    /**
     * @param BannerPosition $bannerPosition
     *
     * @return BannerPosition
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function putBannerPosition(BannerPosition $bannerPosition)
    {
        $uri = '/api/banner-positions/'.$bannerPosition->getId();
        $data = $this->doPutRequest($uri, $bannerPosition);

        return new BannerPosition($data);
    }

    /**
     * @param string $identifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function deleteBannerPosition(string $identifier)
    {
        $uri = '/api/banner-positions/'.$identifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * Post multiple banners to be assigned to a position
     *
     * @param string $identifier        BannerPosition identifier
     * @param array  $bannerIdentifiers Array with banner identifiers to add
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postBannerPositionBanners(string $identifier, array $bannerIdentifiers)
    {
        $uri = '/api/banner-positions/'.$identifier.'/banners';
        $formParams = ['banners' => $bannerIdentifiers];

        return $this->doPostRequest($uri, $formParams);
    }

    /**
     * Remove a banner from banner position
     *
     * @param string $positionIdentifier
     * @param string $bannerIdentifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function removeBannerFromBannerPosition(
        string $positionIdentifier,
        string $bannerIdentifier
    ) {
        $uri = '/api/banner-positions/'.$positionIdentifier.'/banners/'.$bannerIdentifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * Get all ABtests.
     *
     * @param PaginationOptions $options
     *
     * @return PaginatedCollection ABtests collection.
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getABTests(PaginationOptions $options)
    {
        $queryParams = [];

        $queryParams['page'] = $options->getPage();
        $queryParams['limit'] = $options->getLimit();

        if ($options->getFilter()) {
            $queryParams['filter'] = $options->getFilter();
        }

        if ($options->getSort()) {
            $queryParams['sort'] = $options->getSort();
        }

        $data = $this->doGetRequest('/api/ab-tests', $queryParams);

        $bannerPositions = [];

        if ($data['items']) {
            foreach ($data['items'] as $datum) {
                $bannerPositions[] = new ABTest($datum);
            }
        }

        return new PaginatedCollection(
            $bannerPositions,
            $data['count'],
            $data['total'],
            $data['page'],
            $data['total_pages'],
            $data['pages']
        );
    }

    /**
     * Get single ABTest by id
     *
     * @param string $identifier ABTest identifier
     *
     * @return ABTest
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getABTest(string $identifier)
    {
        $data = $this->doGetRequest('/api/ab-tests/'.$identifier);

        if (!empty($data)) {
            return new ABTest($data);
        }

        throw new BannerManagerException("Error reading ABTest data");
    }

    /**
     * @param ABTest $abtest
     *
     * @return ABTest
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postABTest(ABTest $abtest)
    {
        $data = $this->doPostRequest('/api/ab-tests', $abtest->toArray());

        return new ABTest($data);
    }

    /**
     * @param ABTest $abtest
     *
     * @return ABTest
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function putABTest(ABTest $abtest)
    {
        $uri = '/api/ab-tests/'.$abtest->getId();
        $data = $this->doPutRequest($uri, $abtest);

        return new ABTest($data);
    }

    /**
     * @param string $identifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function deleteABTest(string $identifier)
    {
        $uri = '/api/ab-tests/'.$identifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * Post multiple campaigns to be assigned to an ab-test
     *
     * @param string $identifier          ABtest identifier
     * @param array  $campaignIdentifiers Array with campaign identifiers to add
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postABtestCampaigns(string $identifier, array $campaignIdentifiers)
    {
        $uri = '/api/ab-tests/'.$identifier.'/campaigns';
        $formParams = ['campaigns' => $campaignIdentifiers];

        return $this->doPostRequest($uri, $formParams);
    }

    /**
     * Remove a campaign from ab-test
     *
     * @param string $abtestIdentifier
     * @param string $campaignIdentifier
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function removeCampaignFromABTest(string $abtestIdentifier, string $campaignIdentifier)
    {
        $uri = '/api/ab-tests/'.$abtestIdentifier.'/campaigns/'.$campaignIdentifier;

        return $this->doDeleteRequest($uri);
    }

    /**
     * @param string $abtestIdentifier
     * @param Timing $timing
     *
     * @return Timing
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function postABTestTiming(string $abtestIdentifier, Timing $timing)
    {
        $uri = '/api/ab-tests/'.$abtestIdentifier.'/timings';
        $data = $this->doPostRequest($uri, $timing->toArray());

        return new Timing($data);
    }

    /**
     * @param string $abtestIdentifier
     * @param Timing $timing
     *
     * @return Timing
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function putABtestTiming(string $abtestIdentifier, Timing $timing)
    {
        $uri = '/api/ab-tests/'.$abtestIdentifier.'/timings/'.$timing->getId();
        $data = $this->doPutRequest($uri, $timing);

        return new Timing($data);
    }

    /**
     * @param string $abtestIdenitfier
     * @param Timing $timing
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function deleteABTestTiming(string $abtestIdenitfier, Timing $timing)
    {
        $uri = '/api/ab-tests/'.$abtestIdenitfier.'/timings/'.$timing->getId();

        return $this->doDeleteRequest($uri);
    }

    /**
     * Get rotation data for a given banner position name and returns the html to render.
     *
     * @param string $position Position name
     * @param string $session  Session identifier
     *
     * @return string HTML to render
     */
    public function render($position, $session = null): string
    {
        $data = $this->getPositionBanner($position, $session);

        if (!empty($data) && array_key_exists('html', $data)) {
            return $data['html'];
        }

        return '<!-- Could not load banner for position '.$position.' -->';
    }

    /**
     * Get rotation data for a given banner position name and returns the raw data.
     *
     * @param string $position Position name
     * @param string $session  Session identifier
     *
     * @return array Raw Data
     */
    public function getPositionBanner($position, $session = null): array
    {
        $uri = sprintf('/api/banner-positions/%s/rotation', $position);

        try {
            $params = [];
            if ($session) {
                $params['session'] = $session;
            }

            $response = $this->doRequest('GET', $uri, $params);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (GuzzleException $e) {
            return ['error' => 'Could not load banner for position '.$position];
        }

        return [];
    }

    /**
     * Get rotation data for a list of banner position names and returns the html to render.
     *
     * @param array  $positions
     * @param string $session Session identifier
     *
     * @return string HTML to render
     */
    public function renderMultiplePositions(array $positions, $session = null): string
    {
        $data = $this->getMultiplePositionsBanner($positions, $session);

        if (!empty($data) && array_key_exists('html', $data)) {
            return $data['html'];
        }

        return '<!-- Could not load banner for positions '.implode(', ', $positions).' -->';
    }

    /**
     * Get rotation data for a list of banner position names and return the raw data.
     *
     * @param array $positions
     * @param string $session Session identifier
     *
     * @return Rotation|null
     * @throws GuzzleException
     */
    public function getMultiplePositionsBanner(array $positions, $session = null)
    {
        try {
            $uri = '/api/rotation';

            $params = [];
            if ($session) {
                $params['session'] = $session;
            }

            $params['positions'] = $positions;

            $response = $this->doRequest('GET', $uri, $params);
            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            if (!empty($data)) {
                $rotation = new Rotation($data);

                if($this->getProxyUri()) {
                    $rotation->setBannerUrl(
                        str_replace($this->getBaseUri(), $this->getProxyUri(), $rotation->getBannerUrl())
                    );
                }

                return $rotation;
            }

        } catch(Exception $e) {
            $rotation = new Rotation();
            $rotation->setErrors([
                $e->getMessage()
            ]);

            return $rotation;
        }

        return null;
    }

    /**
     * Helper method to send GET requests
     *
     * @param      $url
     *
     * @param null $queryParams
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    private function doGetRequest($url, $queryParams = null)
    {
        $response = $this->doRequest('GET', $url, $queryParams);

        if ($response->getStatusCode() !== 200) {
            throw new BannerManagerException(
                $response->getReasonPhrase(),
                $response->getStatusCode()
            );
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Helper method to send POST requests
     *
     * @param string $uri
     * @param array  $formParams
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    private function doPostRequest(string $uri, array $formParams)
    {
        $response = $this->doRequest('POST', $uri, null, $formParams);

        if ($response->getStatusCode() !== 201 && $response->getStatusCode() !== 200) {
            throw new BannerManagerException(
                $response->getReasonPhrase(),
                $response->getStatusCode()
            );
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Helper method to send PUT requests
     *
     * @param string $uri
     * @param Base   $entity
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    private function doPutRequest(string $uri, Base $entity)
    {
        $formParams = $entity->toArray();

        $response = $this->doRequest('PUT', $uri, null, $formParams);

        if ($response->getStatusCode() !== 200) {
            throw new BannerManagerException(
                $response->getReasonPhrase(),
                $response->getStatusCode()
            );
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Helper method to send DELETE requests
     *
     * @param $url
     *
     * @return bool
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    private function doDeleteRequest($url)
    {
        $response = $this->doRequest('DELETE', $url);

        if ($response->getStatusCode() !== 200) {
            throw new BannerManagerException(
                $response->getReasonPhrase(),
                $response->getStatusCode()
            );
        }

        return true;
    }

    /**
     * Do Multipart request
     *
     * Note:
     * multipart cannot be used with the form_params option. You will need to use one or the other.
     * Use form_params for application/x-www-form-urlencoded requests, and multipart for
     * multipart/form-data requests. This option cannot be used with body, form_params, or json
     *
     * See: http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     *
     * @param string $uri
     * @param array  $multipart
     *
     * @return array
     *
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    private function doMultipartRequest(string $uri, array $multipart)
    {
        $response = $this->doRequest('POST', $uri, null, null, $multipart);

        if ($response->getStatusCode() !== 201 && $response->getStatusCode() !== 200) {
            throw new BannerManagerException(
                $response->getReasonPhrase(),
                $response->getStatusCode()
            );
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Send a request to the API.
     *
     * @param  string    $method      The HTTP method.
     * @param  string    $endpoint    The endpoint.
     * @param  array     $queryParams The query params to send with the request.
     * @param array|null $formParams  The form params to send in POST requests.
     * @param array|null $multipart   The multiform params to send in POST request
     *
     * See: http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    private function doRequest(
        $method,
        $endpoint,
        array $queryParams = null,
        array $formParams = null,
        array $multipart = null
    ) {
        $options = [];
        if (!empty($queryParams)) {
            $options['query'] = $queryParams;
        }

        if (!empty($formParams)) {
            $options['form_params'] = $formParams;
        }

        if (!empty($multipart)) {
            $options['multipart'] = $multipart;
        }

        return $this->http->request($method, $endpoint, $options);
    }
}
