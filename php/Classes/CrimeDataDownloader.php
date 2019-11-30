<?php

namespace GoGitters\ApciMap;

/**
 * Documenting our crime class identifiers compared to our data class identifiers
 *
 * $crimeId = "OBJECTID"
 * $crimeAddress = "CV_BLOCK_ADD"
 * $crimeDate = "date"
 * $crimeLatitude = ""
 * $crimeLongitude = ""
 * $crimeType = "CVINC_TYPE"
 **/

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once(dirname(__DIR__, 2) . "/php/lib/uuid.php");

class DataDownloader {
	public static function pullCrime() {
		$newCrimes = null;
		$urlBase = "../../images/crimes.json";
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/")
	}
}