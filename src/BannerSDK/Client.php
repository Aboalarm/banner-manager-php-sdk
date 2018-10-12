<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 10/2/18
 * Time: 2:32 PM
 */

namespace aboalarm\BannerManagerSdk\BannerSDK;

use GuzzleHttp\Client as Http;


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
     * Get current API user.
     *
     * @return object The user.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBanners()
    {
        return $this->doRequest('GET', '/api/banners');
    }

    /**
     * Get rotation data for a given banner position name and returns the html to render.
     *
     * @param string $position Position name
     * @param string $session Session identifier
     * @param string $device Device identifier
     *
     * @return string HTML to render
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function render($position, $session, $device): string
    {
        $uri = sprintf('/api/banner-positions/%s/rotation', $position);


        $response = $this->doRequest('GET', $uri, ['session' => $session, 'device' => $device]);

        if($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);
        }

        if (!empty($data) && array_key_exists('html', $data)) {
            return $data['html'];
        }

        return '';
    }

    /**
     * Send a request to the API.
     *
     * @param  string $method The HTTP method.
     * @param  string $endpoint The endpoint.
     * @param  array $params The params to send with the request.
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