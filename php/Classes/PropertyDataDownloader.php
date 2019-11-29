<?php


namespace GoGitters\ApciMap;
require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once("./Property.php");


/**
 * This class takes the property data as a JSON format and sticks it in the database
**/
class PropertyDataDownloader {

	/**
	 * This function loops through the properties and puts each one in the database
	 *
	 * @param $urlBase string url to get json data from
	 * @throws \Exception
	 */
	public static function pullProperties($urlBase) {
		$newProperties = null;

		$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
		$pdo = $secrets->getPdoObject();

		$newProperties = self::readDataJson($urlBase);

		//loop through properties and put each one in the database
		foreach($newProperties as $value) {
			$propertyId = generateUuidV4();
			$propertyCity = $value->propertyCity;
			$propertyClass = $value->propertyClass;
			if ($propertyClass === "RES") {
				$propertyClass = "R";
			} else {
				$propertyClass = "C";
			}
			$propertyLatitude= $value->propertyLatitude;
			$propertyLongitude = $value->propertyLongitude;
			$propertyStreetAddress = $value->propertyStreetAddress;
			$propertyValue = $value->propertyValue;
			try {
				$property = new Property($propertyId, $propertyCity, $propertyClass, $propertyLatitude, $propertyLongitude, $propertyStreetAddress, $propertyValue);
				$property->insert($pdo);
			} catch(\TypeError $typeError) {
				echo("Error Connecting to database");
			}
		}
		echo("Done");
	}


	public static function readDataJson($url) {
		$context = stream_context_create(["http" => ["ignore_errors" => true, "method" => "GET"]]);
		//file-get-contents returns file in string context
		if(($jsonData = file_get_contents($url, null, $context)) === false) {
			throw(new \RuntimeException("url doesn't produce results"));
		}
		//decode the Json file
		$jsonConverted = json_decode($jsonData);

		//pull out the property array
		$jsonFeatures = $jsonConverted->properties;
		$newProperties = \SplFixedArray::fromArray($jsonFeatures);
		return ($newProperties);
	}


}
//url to get json data from
$url1 = "https://bootcamp-coders.cnm.edu/~kbendt/apcimap/data/prop1.json";
$url2 = "https://bootcamp-coders.cnm.edu/~kbendt/apcimap/data/prop2.json";
$url3 = "https://bootcamp-coders.cnm.edu/~kbendt/apcimap/data/prop3.json";
$url4 = "https://bootcamp-coders.cnm.edu/~kbendt/apcimap/data/prop4.json";
$url5 = "https://bootcamp-coders.cnm.edu/~kbendt/apcimap/data/prop5.json";

//TODO: uncomment 5 lines below to rerun import

//echo PropertyDataDownloader::pullProperties($url1).PHP_EOL;
//echo PropertyDataDownloader::pullProperties($url2).PHP_EOL;
//echo PropertyDataDownloader::pullProperties($url3).PHP_EOL;
//echo PropertyDataDownloader::pullProperties($url4).PHP_EOL;
//echo PropertyDataDownloader::pullProperties($url5).PHP_EOL;