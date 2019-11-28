<?php


namespace GoGitters\ApciMap;
require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/uuid.php");


/**
 * This class takes the property data as a JSON format and sticks it in the database
**/
class PropertyDataDownloader {

	/**
	* This function loops through the properties and puts each one in the database
	**/
	public static function pullProperties() {
		$newProperties = null;
		//url to get json data from
		$urlBase = "https://bootcamp-coders.cnm.edu/~kbendt/apcimap/data/prop-small.json";
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
		$pdo = $secrets->getPdoObject();

		$newProperties = self::readDataJson($urlBase);

		//loop through properties and put each one in the database
		foreach($newProperties as $value) {
			$propertyId = generateUuidV4();
			$propertyCity = $value->propertyCity;
			$propertyClass = $value->propertyClass;
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
		var_dump($jsonFeatures);
		$newProperties = \SplFixedArray::fromArray($jsonFeatures);
		return ($newProperties);
	}


}

echo PropertyDataDownloader::pullProperties().PHP_EOL;