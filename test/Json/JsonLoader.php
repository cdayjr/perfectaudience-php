<?php

class JsonLoader
{

	const AUTH_FOLDER = "/Auth";

	public static function getAccessTokenJson() {
		return file_get_contents(__DIR__ . self::AUTH_FOLDER . "/access_token.json");
	}

	public static function getErrorJson() {
		return file_get_contents(__DIR__ . "/error.json");
	}
}
