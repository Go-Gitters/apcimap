<?php


namespace GoGitters\ApciMap;
require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/uuid.php");


/**
 * This class takes the property data as a JSON format and sticks it in the database
**/
class PropertyDataDownloader {

	public static function pullProperties() {
		$newProperties = null;

		$urlBase = "https://bootcamp-coders.cnm.edu/~kbendt/apcimap/data/prop.json";
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
		$pdo = $secrets->getPdoObject();

		$newProperties = self::readDataJson($urlBase);

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


}