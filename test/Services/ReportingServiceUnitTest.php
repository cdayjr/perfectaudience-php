<?php

use Prad\Services\ReportingService;
use Prad\Util\CurlResponse;

class ReportingServiceUnitTest extends PHPUnit_Framework_TestCase {

	private $restClient;
	private $auth;
	private $reportingService;

	public function setUp() {
		$this->restClient = $this->getMock('\Prad\Util\RestClientInterface');
		$this->auth = $this->getMock('\Prad\Auth\PradOAuthInterface');
		$this->reportingService = new ReportingService($this->auth, $this->restClient);
	}

	public function testGetStatus() {
		// Mock the authentication
		$this->auth->expects($this->once())
			->method('getAccessToken')
			->with()
			->will($this->returnValue('token'));

		// Mock the reponse of the API.
		$curlResponse = CurlResponse::create(JsonLoader::getReportingStatusJson(), array('http_code' => 200));
		$this->restClient->expects($this->once())
			->method('get')
			->with()
			->will($this->returnValue($curlResponse));

		$date = $this->reportingService->getStatus('status');

		$this->assertEquals('2013-02-08T17:00:00Z', $date);
	}

	public function testGetCampaignReports() {
		// Mock the authentication
		$this->auth->expects($this->once())
			->method('getAccessToken')
			->with()
			->will($this->returnValue('token'));

		// Mock the reponse of the API.
		$curlResponse = CurlResponse::create(JsonLoader::getCampaignReportJson(), array('http_code' => 200));
		$this->restClient->expects($this->once())
			->method('get')
			->with()
			->will($this->returnValue($curlResponse));

		$campaigns = $this->reportingService->getCampaignReport();

		$this->assertEquals(2, count($campaigns));
		$this->assertEquals('941e29f625f97b74620000e7', $campaigns[0]->campaign_id);
	}
}
