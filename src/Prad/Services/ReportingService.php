<?php
namespace Prad\Services;

use Prad\Util\Config;

/**
 * Performs all actions pertaining to reporting the Perfect Audience.
 *
 * @package Services
 * @author  Baptiste Pernet
 */
class ReportingService extends BaseService {

	/**
	 * Get the status of the reporting.
	 * Use the data status service to check when new performance data is available.
	 * @params string $dataType - type of report we get the date: campaign_report, ad_report, conversion_report
	 * @return string - The UTC timestamp at which the data source was last updated.
	 */
	public function getStatus($dataType) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.report.status');
		$url = $this->buildUrl($baseUrl, array('data_type' => $dataType));
		$response = $this->getRestClient()->get($url, $this->getHeaders());
		$jsonResponse = json_decode($response->body, true);

		return $jsonResponse['data_status']['last_updated'];
	}
}
