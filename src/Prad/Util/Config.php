<?php
namespace Prad\Util;

/**
 * Configuration class to hold endpoints, urls, errors messages etc.
 *
 * @package	 Util
 * @author	 Baptiste Pernet
 */
class Config {

	/**
	 * @var array - array of configuration properties
	 */
	private static $props = array(

		/**
		 * REST endpoints
		 */
		'endpoints' => array(
			'base_url' => 'https://api.perfectaudience.com/',
			'auth' => 'auth',
			'report' => array(
				'status' => 'data_status',
				'campaign' => 'reports/campaign_report',
				'ad' => 'reports/ad_report',
				'segment' => 'reports/segment_size_report',
			),
			'campaign' => '/campaigns',
			'segment' => '/segments',
			'ad' => 'ads',
		),

		/**
		 * Errors to be returned for various exceptions
		 */
		'errors' => array(
			'id_or_object' => 'Only an id or %s object are allowed for this method.'
		)

	);

	/**
	 * Get a configuration property given a specified location, example usage: Config::get('auth.token_endpoint')
	 * @param $index - location of the property to obtain
	 * @return string
	 */
	public static function get($index) {
		$index = explode('.', $index);
		return self::getValue($index, self::$props);
	}

	/**
	 * Navigate through a config array looking for a particular index
	 * @param array $index The index sequence we are navigating down
	 * @param array $value The portion of the config array to process
	 * @return mixed
	 */
	private static function getValue($index, $value) {
		if (is_array($index) && count($index)) {
			$current_index = array_shift($index);
		}
		if (is_array($index) && count($index) && is_array($value[$current_index]) && count($value[$current_index])) {
			return self::getValue($index, $value[$current_index]);
		} else {
			return $value[$current_index];
		}
	}
}
