<?php


namespace GoGitters\ApciMap;

use http\Exception\InvalidArgumentException;

/**
 * This class represents a property and includes attributes like latitude, longitude & assessed values.
 *
 * @author Kyla Bendt
 * @version 0.0.1
 *
 **/

class Property {
	/********************************************
	 * Declare and document all state variables *
	 ********************************************/
	/**
	 * id for this property.  this is the primary key.
	 * @var Uuid $propertyUuid
	 **/
	private $propertyUuid;

	/**
	 * city for this property.  (some entries will also include state & zip)
	 * max length = 80
	 * @var string $propertyCity
	 **/
	private $propertyCity;

	/**
	 * class for this property 'C' for commercial or 'R' for residential
	 * @var string $propertyClass
	 **/
	private $propertyClass;
	/**
	 * latitude for this property
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $propertyLatitude
	 **/
	private $propertyLatitude;

	/**
	 * longitude for this property
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $propertyLongitude
	 **/
	private $propertyLongitude;

	/**
	 * street address for this property.  (address number & street name)
	 * max length = 134
	 * @var string $propertyStreetAddress
	 **/
	private $propertyStreetAddress;

	/**
	 * assessed value for this property
	 * MySQL type - DECIMAL(15, 2)
	 **/
	private $propertyValue;

	/********************************************
	 * Constructor method                  *
	 ********************************************/

	/**
	 * constructor for this Property
	 *
	 * @param string|Uuid $newPropertyUuid of this Property
	 * @param string $newPropertyCity
	 * @param string $newPropertyClass
	 * @param float $newPropertyLatitude
	 * @param float $newPropertyLongitude
	 * @param string $newPropertyStreetAddress
	 * @param float $newPropertyValue
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newPropertyUuid, $newPropertyCity, $newPropertyClass, $newPropertyLatitude, $newPropertyLongitude, $newPropertyStreetAddress, $newPropertyValue) {
		try {
			$this->setPropertyUuid($newPropertyUuid);
			$this->setPropertyCity($newPropertyCity);
			$this->setPropertyClass($newPropertyClass);
			$this->setPropertyLatitude($newPropertyLatitude);
			$this->setPropertyLongitude($newPropertyLongitude);
			$this->setPropertyStreetAddress($newPropertyStreetAddress);
			$this->setPropertyValue($newPropertyValue);
		}
		catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/********************************************
	 *Getters and Setters                       *
	 ********************************************/
	/****************
	 * $propertyUuid
	 ***************/

	/**
	 * accessor method for property Uuid
	 *
	 * @return Uuid value of property uuid
	 **/
	public function getPropertyUuid() : Uuid {
		return($this->propertyUuid);
	}

	/**
	 * mutator method for property Uuid
	 *
	 * @param Uuid|string $newPropertyUuid new value of property uuid
	 * @throws \RangeException if $newPropertyUuid is not positive
	 * @throws \TypeError if $newPropertyUuid is not a uuid or string
	 **/
	public function setPropertyUuid( $newPropertyUuid) : void {
		try {
			$uuid = self::validateUuid($newPropertyUuid);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//store the property uuid
		$this->propertyUuid = $uuid;
	}

	/*****************
	 *$propertyCity
	 ****************/

	/**
	 * accessor method for property city
	 *
	 * @return string property city
	 **/
	public function getPropertyCity() : string {
		return($this->propertyCity);
	}

	/**
	 * mutator method for property city
	 *
	 * @param string $newPropertyCity new value of property city
	 * @throws \InvalidArgumentException if $newPropertyCity is not a string or is insecure
	 * @throws \RangeException if $newPropertyCity is > 80 characters
	 * @throws \TypeError if $newPropertyCity is not a string
	 **/

	public function setPropertyCity(string $newPropertyCity) : void {
		//verify input is secure
		//Right now, we're feeding in the data, but we'll do this anyway just in case that changes
		$newPropertyCity = trim($newPropertyCity);
		$newPropertyCity = filter_var($newPropertyCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPropertyCity) === true) {
			throw(new \InvalidArgumentException("property city is empty or insecure"));
		}

		//verify the content will fit in the database
		if(strlen($newPropertyCity) > 80) {
			throw(new \RangeException("property city has more than 80 characters"));
		}

		//store the property city
		$this->propertyCity = $newPropertyCity;
	}

	/*****************
	 * $propertyClass
	 *****************/
	/**
	 * accessor method for property class ('R' or 'C')
	 *
	 * @return string property class ('R' or 'C')
	 **/
	public function getPropertyClass() : string {
		return($this->propertyClass);
	}
	/**
	 * mutator method for property class
	 *
	 * @param string $newPropertyClass new value of property class 'R' or 'C' for Residential or Commercial
	 * @throws \InvalidArgumentException if $newPropertyClass is not an 'R' or a 'C'
	 * @throws \TypeError if $newPropertyClass is not a string
	 **/

	public function setPropertyClass(string $newPropertyClass) : void {
		//verify input is of correct form
		if($newPropertyClass != ('R' || 'C')) {
			throw(new \InvalidArgumentException("class type must be 'R' or 'C'"));
		}

		//store the property class
		$this->propertyClass = $newPropertyClass;
	}

	/*******************
	 * $propertyLatitude
	 *******************/
	/**
	 * accessor method for property latitude
	 *
	 * @return float latitude
	 **/
	public function getPropertyLatitude() : float {
		return($this->propertyLatitude);
	}

	/**
	 * mutator method for property latitude
	 *
	 * @param float $newPropertyLatitude
	 * @throws \InvalidArgumentException if $newPropertyLatitude is not >= -90 and <=90
	 * @throws \TypeError if $newPropertyLatitude is not a float
	 **/
	public function setPropertyLatitude(float $newPropertyLatitude) : void {
		//verify input is of correct form
		//This checks that it is a valid latitude
		// and  ensures it has the correct number of digits to the left of the decimal for the database
		if(!($newPropertyLatitude >= -90) && ($newPropertyLatitude <= 90)) {
			throw(new \InvalidArgumentException("latitude must be between -90 and 90"));
		}
		//set precision to 6 decimals
		$newPropertyLatitude = round($newPropertyLatitude, 6);
		//store the property class
		$this->propertyLatitude = $newPropertyLatitude;
	}	
	/********************
	 * $propertyLongitude
	 ********************/
	/**
	 * accessor method for property longitude
	 *
	 * @return float longitude
	 **/
	public function getPropertyLongitude() : float {
		return($this->propertyLongitude);
	}

	/**
	 * mutator method for property longitude
	 *
	 * @param float $newPropertyLongitude
	 * @throws \InvalidArgumentException if $newPropertyLongitude is not >= -180 and <=180
	 * @throws \TypeError if $newPropertyLongitude is not a float
	 **/
	public function setPropertyLongitude(float $newPropertyLongitude) : void {
		//verify input is of correct form
		//This checks that it is a valid longitude
		// and  ensures it has the correct number of digits to the left of the decimal for the database
		if(!($newPropertyLongitude >= -180) && ($newPropertyLongitude <= 180)) {
			throw(new \InvalidArgumentException("longitude must be between -180 and 180"));
		}
		//set precision to 6 decimals
		$newPropertyLongitude = round($newPropertyLongitude, 6);
		//store the property class
		$this->propertyLongitude = $newPropertyLongitude;
	}

	/************************
	 * $propertyStreetAddress
	 ***********************/
	/**
	 * accessor method for property street address
	 *
	 * @return string property street address
	 **/
	public function getPropertyStreetAddress() : string {
		return($this->propertyStreetAddress);
	}

	/**
	 * mutator method for property street address
	 *
	 * @param string $newPropertyStreetAddress new value of property street address
	 * @throws \InvalidArgumentException if $newPropertyStreetAddress is not a string or is insecure
	 * @throws \RangeException if $newPropertyStreetAddress is > 134 characters
	 * @throws \TypeError if $newPropertyStreetAddress is not a string
	 **/

	public function setPropertyStreetAddress(string $newPropertyStreetAddress) : void {
		//verify input is secure
		//Right now, we're feeding in the data, but we'll do this anyway just in case that changes
		$newPropertyStreetAddress = trim($newPropertyStreetAddress);
		$newPropertyStreetAddress = filter_var($newPropertyStreetAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPropertyStreetAddress) === true) {
			throw(new \InvalidArgumentException("property street address is empty or insecure"));
		}

		//verify the content will fit in the database
		if(strlen($newPropertyStreetAddress) > 134) {
			throw(new \RangeException("property street address has more than 134 characters"));
		}

		//store the property street address
		$this->propertyStreetAddress = $newPropertyStreetAddress;
	}

	/****************
	 * $propertyValue
	 ****************/
	/**
	 * accessor method for property value
	 *
	 * @return float property value
	 **/
	public function getPropertyValue() : float {
		return($this->propertyValue);
	}

	/**
	 * mutator method for property value
	 *
	 * @param float $newPropertyValue
	 * @throws \InvalidArgumentException if $newPropertyValue is not valid for DECIMAL(15,2) for Database
	 * @throws \TypeError if $newPropertyValue is not a float
	 **/
	public function setPropertyValue(float $newPropertyValue) : void {
		//verify input is of correct form
		//This checks that it is a valid value
		// and  ensures it has the correct number of digits to the left of the decimal for the database
		if(!($newPropertyValue >= 0) && ($newPropertyValue <= 9999999999999)) {
			throw(new \InvalidArgumentException("value must be >= 0 and <= 9999999999999"));
		}
		//set precision to 2 decimals
		$newPropertyValue = round($newPropertyValue, 2);
		//store the property class
		$this->propertyValue = $newPropertyValue;
	}


	/*******************************************
	 * DBO Methods
	 *******************************************/

	/**
	 * inserts this Property into MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO property(propertyUuid, propertyCity, propertyClass, propertyLatitude, propertyLongitude, propertyStreetAddress, propertyValue) VALUES(:propertyUuid, :propertyCity, :propertyClass, :propertyLatitude, :propertyLongitude, :propertyStreetAddress, :propertyValue)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["propertyUuid" => $this->propertyUuid->getBytes(), "propertyCity" => $this->propertyCity, "propertyClass" => $this->propertyClass, "propertyLatitude" => $this->propertyLatitude, "propertyLongitude" => $this->propertyLongitude, "propertyStreetAddress" => $this->propertyStreetAddress, "propertyValue" => $this->propertyValue];
		$statement->execute($parameters);
	}

	/**
	 * deletes this property from MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM property WHERE propertyUuid = :propertyUuid";
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holder in the template
		$parameters = ["propertyUuid" => $this->propertyUuid->getBytes()];
	}

	/**
	 * updates this Property in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		//create query template
		$query = "UPDATE property SET propertyUuid = :propertyUuid, propertyCity = :propertyCity, propertyClass = :propertyClass, propertyLatitude = :propertyLatitud, propertyLongitude = :propertyLongitude, propertyStreetAddress = :propertyStreetAddress, propertyValue = :propertyValue WHERE propertyUuid = :propertyUuid";
		$statement = $pdo->prepare($query);

		//bind member variables to template
		$parameters = ["propertyUuid" => $this->propertyUuid->getBytes(), "propertyCity" => $this->propertyCity, "propertyClass" => $this->propertyClass, "propertyLatitude" => $this->propertyLatitude, "propertyLongitude" => $this->propertyLongitude, "propertyStreetAddress" => $this->propertyStreetAddress, "propertyValue" => $this->propertyValue];
		$statement->execute($parameters);
	}

	/********************************************
	 * TODO GetFooByBars                        *
	 ********************************************/

	/**
	 * gets the Property by propertyUuid
	 *
	 * @param \PDO $pdo connection object
	 * @param Uuid|string $propertyUuid property uuid to search for
	 * @return Property|null Property found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 */
	public static function getPropertyByPropertyUuid(\PDO $pdo, $propertyUuid) : ?Property {
		// sanitize the propertyUuid before searching
		try {
			$propertyUuid = self::validateUuid($propertyUuid);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT propertyUuid, propertyCity, propertyClass, propertyLatitude, propertyLongitude, propertyStreetAddress, propertyValue FROM property WHERE propertyUuid = :propertyUuid";
		$statement = $pdo->prepare($query);

		//bind the property uuid to the place holder
		$parameters = ["propertyUuid" => $propertyUuid->getBytes()];
		$statement->execute($parameters);

		// grab the property from mySQL
		try {
			$property = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$property = new Property($row["propertyUuid"], $row["propertyCity"], $row["propertyLatitude"], $row["propertyLongitude"], $row["propertyStreetAddress"], $row["propertyValue"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($property);
	}

	//TODO fill in
	public static function getPropertyByUserUuid(\PDO $pdo, $userUuid) : \SplFixedArray {

	}

	//TODO fill in
	public static function getPropertyAllProperty(\PDO $pdo) : \SplFixedArray {

	}

//Closing bracket for Class!!!!!!!!!!!!!!!!!!!
}