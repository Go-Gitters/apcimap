<?php


namespace GoGitters\ApciMap;

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
	 * TODO Constructor method                  *
	 ********************************************/

	/********************************************
	 * TODO Getters and Setters                 *
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
	 * @thrwos \TypeError if $newPropertyCity is not a string
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
			throw(new \RangeException("property city has too many characters"));
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

	/**
	 * TODO $propertyLatitude
	 **/
	/**
	 * accessor method for property latitude
	 *
	 * @return float latitude
	 **/
	public function getPropertyLatitude() : float {
		return($this->propertyLatitude);
	}

	/**
	 * TODO $propertyLongitude
	 **/
	/**
	 * accessor method for property longitude
	 *
	 * @return float longitude
	 **/
	public function getPropertyLongitude() : float {
		return($this->propertyLongitude);
	}

	/**
	 * TODO $propertyStreetAddress
	 **/
	/**
	 * accessor method for property street address
	 *
	 * @return string property street address
	 **/
	public function getPropertyStreetAddress() : string {
		return($this->propertyStreetAddress);
	}

	/**
	 * TODO $propertyValue
	 **/
	/**
	 * accessor method for property value
	 *
	 * @return float property value
	 **/
	public function getPropertyValue() : float {
		return($this->propertyValue);
	}

	/********************************************
	 * TODO GetFooByBars                        *
	 ********************************************/

//Closing bracket for Class!!!!!!!!!!!!!!!!!!!
}