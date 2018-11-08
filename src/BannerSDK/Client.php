<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 10/2/18
 * Time: 2:32 PM
 */

namespace aboalarm\BannerManagerSdk\BannerSDK;

use aboalarm\BannerManagerSdk\Entity\Banner;
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
     * @return Banner[]|null Banner collection.
     * @throws GuzzleException
     */
    public function getBanners()
    {
        $response = $this->doRequest('GET', '/api/banners');

        $data = json_decode($response->getBody(), true);

        if(!empty($data)) {
            $banners = [];

            foreach ($data as $datum) {
                $banners[] = new Banner($datum);
            }

            return $banners;
        }

        return null;
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
                'error' => 'Could not load banner for positions '.implode(', ', $positions)
            ];
        }

        return [];
    }

    /**
     * Send a request to the API.
     *
     * @param  string $method   The HTTP method.
     * @param  string $endpoint The endpoint.
     * @param  array  $params   The params to send with the request.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function doRequest($method, $endpoint, array $params = null)
    {
        $options = [];
        if (!empty($params)) {
            $options['query'] = $params;
        }

        return $this->http->request($method, $endpoint, $options);
    }
}
