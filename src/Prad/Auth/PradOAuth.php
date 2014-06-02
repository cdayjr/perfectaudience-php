<?php
namespace Prad\Auth;

use Prad\Util\Config;
use Prad\Util\RestClient;
use Prad\Exceptions\OAuthException;

/**
 * Class that implements necessary functionality to obtain an access token from a user
 *
 * @package Auth
 * @author  Baptiste Pernet
 */
class PradOAuth implements PradOAuthInterface {

	/**
	 * @var string $clientId the Perfect Audience user.
	 */
	public $clientId;

	/**
	 * @var string $clientSecret the password for the Perfect Audiance user.
	 */
	public $clientSecret;

	/**
	 * @var object $sessionDataStore session store to save the token.
	 */
	private $pradDataStore;

	public function __construct($clientId, $clientSecret, $restClient = null, $pradDataStore = null) {
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->restClient = ($restClient) ? $restClient : new RestClient();
		$this->pradDataStore = ($pradDataStore) ? $pradDataStore : new SessionDataStore();
	}

	/**
	 * Obtain an access token. This token is valid for two hours and need to be
	 * @return array
	 * @throws \Prad\Exceptions\OAuth2Exception
	 */
	public function getAccessToken() {
		// The token that may be valid in the data store.

		$token = $this->pradDataStore->getAccessToken($this->clientId);
		if ($token) {
			return $token;
		}

		// Parameters to make a request.
		$params = array(
			'email' => $this->clientId,
			'password' => $this->clientSecret,
		);

		// Get the url to make the request.
		$url = Config::get('endpoints.base_url') . Config::get('endpoints.auth') . '?' . http_build_query($params);

		// Make the request and decode it.
		$response = $this->restClient->post($url);
		$responseBody = json_decode($response->body, true);

		// Handle the error case.
		if (array_key_exists('error_code', $responseBody)) {
			throw new OAuthException($responseBody['error_code'] . ': ' . $responseBody['error_message']);
		}

		// Get the token.
		$token = $responseBody['token'];

		// Save the token in the datastore, with 2 hours expiration.
		$this->pradDataStore->addAccessToken($this->clientId, $token, time() + 120 * 60);

		// Return the token.
		return $token;
	}
}
