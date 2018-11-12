<?php

namespace aboalarm\BannerManagerSdk\BannerSDK;

use aboalarm\BannerManagerSdk\Entity\Banner;
use aboalarm\BannerManagerSdk\Entity\Base;
use aboalarm\BannerManagerSdk\Entity\Campaign;
use aboalarm\BannerManagerSdk\Exception\BannerManagerException;
use aboalarm\BannerManagerSdk\Pagination\PaginatedCollection;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\GuzzleException;

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
     * @param string $baseUri  The API base uri
     * @param string $username The API user username.
     * @param string $password The API user password.
     */
    public function __construct($baseUri, $username, $password)
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
            ]
        );
    }

    /**
     * Get all banners.
     *
     * @return PaginatedCollection Banner collection.
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getBanners()
    {
        $data = $this->doGetRequest('/api/banners');

        $banners = [];

        foreach ($data as $datum) {
            $banners[] = new Banner($datum);
        }

        return new PaginatedCollection($banners, count($banners), 1, 1);
    }

    /**
     * Get all campaigns.
     *
     * @return PaginatedCollection Campaign collection.
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    public function getCampaigns()
    {
        $data = $this->doGetRequest('/api/campaigns');

        $campaigns = [];

        foreach ($data as $datum) {
            $campaigns[] = new Campaign($datum);
        }

        return new PaginatedCollection($campaigns, count($campaigns), 1, 1);
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
        $data = $this->doPostRequest('/api/campaigns', $campaign);

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
     * @param array  $positions
     * @param string $session Session identifier
     *
     * @return array Raw Data
     */
    public function getMultiplePositionsBanner(array $positions, $session = null): array
    {
        $uri = '/api/rotation';

        try {
            $params = [];
            if ($session) {
                $params['session'] = $session;
            }

            $params['positions'] = $positions;

            $response = $this->doRequest('GET', $uri, $params);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (GuzzleException $e) {
            return [
                'error' => 'Could not load banner for positions '.implode(', ', $positions),
            ];
        }

        return [];
    }

    /**
     * Helper method to send GET requests
     *
     * @param $url
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    private function doGetRequest($url)
    {
        $response = $this->doRequest('GET', $url);

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
     * @param Base   $entity
     *
     * @return array
     * @throws BannerManagerException
     * @throws GuzzleException
     */
    private function doPostRequest(string $uri, Base $entity)
    {
        $formParams = $entity->toArray();

        $response = $this->doRequest('POST', $uri, null, $formParams);

        if ($response->getStatusCode() !== 201) {
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
     * Send a request to the API.
     *
     * @param  string    $method      The HTTP method.
     * @param  string    $endpoint    The endpoint.
     * @param  array     $queryParams The query params to send with the request.
     * @param array|null $formParams  The form params to send in POST requests.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    private function doRequest(
        $method,
        $endpoint,
        array $queryParams = null,
        array $formParams = null
    ) {
        $options = [];
        if (!empty($queryParams)) {
            $options['query'] = $queryParams;
        }

        if (!empty($formParams)) {
            $options['form_params'] = $formParams;
        }

        return $this->http->request($method, $endpoint, $options);
    }
}
