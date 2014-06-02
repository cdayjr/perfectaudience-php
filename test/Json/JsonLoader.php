<?php

class JsonLoader {

	const AUTH_FOLDER = '/Auth';
	const REPORTING_FOLDER = '/Reporting';

	public static function getAccessTokenJson() {
		return file_get_contents(__DIR__ . self::AUTH_FOLDER . '/access_token.json');
	}

	public static function getReportingStatusJson() {
		return file_get_contents(__DIR__ . self::REPORTING_FOLDER . '/status.json');
	}

	public static function getCampaignReportJson() {
		return file_get_contents(__DIR__ . self::REPORTING_FOLDER . '/campaign_report.json');
	}

	public static function getErrorJson() {
		return file_get_contents(__DIR__ . '/error.json');
	}
}
