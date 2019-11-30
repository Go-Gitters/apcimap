<?php

namespace GoGitters\ApciMap;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once("./Crime.php");

/**
 * This class takes the crime incident reports data as a JSON format and sticks it in the database
 **/
class CrimeDataDownloader {

	/**
	 * This function loops through the crime incident reports and puts each one in the database
	 *
	 * @param $urlBase string url to get json data from
	 * @throws \Exception
	 **/
	public static function pullCrimes($urlBase) {
		$newCrimes = null;

		$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
		$pdo = $secrets->getPdoObject();

		$crimes = self::readDataJson($urlBase);

		// loop through crime incident reports and put each one in the database
		foreach($newCrimes as $value) {
			$crimeId = generateUuidV4();
			$crimeAddress = $value->crimeAddress;
			$crimeDate = $value->crimeDate;
			$crimeLatitude = $value->crimeLatitude;
			$crimeLongitude = $value->crimeLongitude;
			$crimeType = $value->crimeType;
			try {
				$crime = new Crime($crimeId, $crimeAddress, $crimeDate, $crimeLatitude, $crimeLongitude, $crimeType);
				$crime->insert($pdo);
			} catch(\TypeError $typeError) {
				echo("Error connecting to database");
			}
		}
		echo("Done");
	}

	public static function readDataJson($url) {
		$context = stream_context_create(["http" => ["ignore_errors" => true, "method" => "GET"]]);
		// file-get-contents returns file in string context
		if(($jsonData = file_get_contents($url, null, $context)) === false) {
			throw(new \RuntimeException("url doesn't produce results"));
		}
		// decode the Json file
		$jsonConverted = json_decode($jsonData);

		// pull out the crime incident reports array
		$jsonFeatures = $jsonConverted->crimes;
		$newCrimes = \SplFixedArray::fromArray($jsonFeatures);
		return ($newCrimes);
	}

	/**
	 * This function returns a count of rows in the crime incident reports table
	 **/
	public static function crimeCount() {
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
		$pdo = $secrets->getPdoObject();
		$query = "SELECT COUNT(*) FROM crime";
		$statement = $pdo->prepare($query);
		$statement->execute();
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		echo("crime incident reports count = " . $row['COUNT(*)']);
	}
}
// url to get json data from
$url1 = "https://bootcamp-coders.cnm.edu/~llee28/apcimap/data/crime.json";

echo CrimeDataDownloader::crimeCount();