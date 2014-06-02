<?php
namespace Prad\Services;

use Prad\Util\PradOAuth;
use Prad\Util\RestClient;
use Prad\Util\RestClientInterface;

/**
 * Super class for all services
 *
 * @package Services
 * @author  Baptiste Pernet
 */
abstract class BaseService
{
	/**
	 * RestClient Implementation to use for HTTP requests
	 * @var $restClient - RestClient
	 */
	protected $restClient;

	/**
	 * Authentication service to get the token to make request.
	 * @var $auth - PradOAuth
	 */
	protected $auth;

	/**
	 * Constructor with the option to to supply an alternative rest client to be used
	 * @param PradOAuth $auth - Perfect Audience authentication service.
	 * @param RestClientInterface $restClient - RestClientInterface implementation to be used in the service
	 */
	public function __construct($auth, $restClient = null) {
		$this->auth = $auth;
		$this->restClient = ($restClient) ? $restClient : new RestClient();
	}

	/**
	 * Build a URL from a base url and optional array of query parameters to append to the url. URL query parameters
	 * should not be URL encoded and this method will handle that.
	 * @param $url
	 * @param array $queryParams
	 * @return string
	 */
	public function buildUrl($url, array $queryParams = null) {
		$keyArr = array('api_key' => $this->apiKey);
		if ($queryParams) {
			$params = array_merge($keyArr, $queryParams);
		} else {
			$params = $keyArr;
		}

		return $url . '?' . http_build_query($params, '', '&');
	}

	/**
	 * Get the rest client being used by the service
	 * @return RestClientInterface - RestClientInterface implementation being used
	 */
	public function getRestClient() {
		return $this->restClient;
	}

	/**
	 * Set the rest client being used by the service
	 * @params $restClient - RestClientInterface implementation being used
	 */
	public function setRestClient(RestClientInterface $restClient) {
		$this->restClient = $restClient;
	}

	/**
	 * Helper function to return required headers for making an http request with Perfect Audience
	 * @return array - authorization headers
	 */
	protected function getHeaders() {
		// Get the token.
		$accessToken = $this->auth->getAccessToken();

		// Return the headers.
		return array(
			'Content-Type: application/json',
			'Accept: application/json',
			'Authorization: ' . $accessToken
		);
	}
}
