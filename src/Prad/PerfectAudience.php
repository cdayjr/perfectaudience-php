<?php
namespace Prad;

use Prad\Auth\PradOAuth;
use Prad\Services\ReportingService;

define('PRAD_VERSION', '0.0.1');

/**
 * Exposes all implemented Perfect Audience API functionality.
 *
 * @package Prad
 * @version 0.0.1
 * @author Baptiste Pernet
 * @link http://support.perfectaudience.com/knowledgebase/topics/35920-api-documentation
 */
class PerfectAudience {

	/**
	 * Handles interaction with the reporting.
	 * @var ReportingService
	 */
	protected $reportingService;

	/**
	 * Class constructor
	 * Get the authentication service and initiate all the service objects.
	 * @param string $clientId - Perfect Audience user id.
	 * @param string $clientSecret - Perfect Audience user password.
	 */
	public function __construct($clientId, $clientSecret) {
		$auth = new PradOAuth($clientId, $clientSecret);
		$this->reportingService = new ReportingService($auth);
	}

	/**
	 * Get the status of the reporting.
	 * Use the data status service to check when new performance data is available.
	 * @params string $dataType - type of report we get the date: campaign_report, ad_report, conversion_report
	 * @return string - The UTC timestamp at which the data source was last updated.
	 */
	public function getDataStatus($dataType) {
		return $this->reportingService->getStatus($dataType);
	}
}
