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
	/*
	 * TODO $propertyUuid
	 */

	/*
	 * TODO $propertyCity
	 */

	/*
	 * TODO $propertyClass
	 */

	/*
	 * TODO $propertyLatitude
	 */

	/*
	 * TODO $propertyLongitude
	 */

	/*
	 * TODO $propertyStreetAddress
	 */

	/*
	 * TODO $propertyValue
	 */


	/********************************************
	 * TODO GetFooByBars                        *
	 ********************************************/

//Closing bracket for Class!!!!!!!!!!!!!!!!!!!
}