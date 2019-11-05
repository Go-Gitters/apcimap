<?php


namespace GoGitters\ApciMap\Test;

//grab the Property Class
use GoGitters\ApciMap\{Property};
use Ramsey\Uuid\Uuid;

require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Class PropertyTest
 *
 * A complete PHPUnit test of the Property class.  It is complete because *ALL* mySQL/PDO enabled methods are tested for
 * both valid and invalid inputs
 *
 * @see Property
 * @package GoGitters\ApciMap\Test
 *
 * @author Kyla Bendt
 */


class PropertyTest extends ApciMapTest {


	/**
	 * valid city to use as propertyCity
	 * max length = 80
	 * @var string $VALID_PROPERTYCITY
	 **/
	protected $VALID_PROPERTYCITY = "Albuquerque, NM";

	/**
	 * valid class to use as propertyClass
	 * class for this property 'C' for commercial or 'R' for residential
	 * @var string $VALID_PROPERTYCLASS
	 **/
	protected $VALID_PROPERTYCLASS = "R";

	/**
	 * valid latitude to use as propertyLatitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $VALID_PROPERTYLATITUDE
	 **/
	protected $VALID_PROPERTYLATITUDE = 35.093862;

	/**
	 * valid longitude to use as propertyLongitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $VALID_PROPERTYLONGITUDE
	 **/
	protected $VALID_PROPERTYLONGITUDE = -106.640396;

	/**
	 * valid street address to use as propertyStreetAddress
	 * max length = 134
	 * @var string $VALID_PROPERTYSTREETADDRESS
	 **/
	protected $VALID_PROPERTYSTREETADDRESS = "8978 Easy Street";

	/**
	 * valid assessed value to use as propertyAssessedValue
	 * assessed value for this property
	 * MySQL type - DECIMAL(15, 2)
	 * @var float $VALID_PROPERTYASSESSEDVALUE
	 **/
	protected $VALID_PROPERTYASSESSEDVALUE = "5096837.87";

	public final function setUp() : void {
		parent::setUp();
	}

	public function testInsertValidProperty() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("property");

		//make a valid property uuid
		$propertyUuid = generateUuidV4();

		//make a new property with valid entries
		$property = new Property($propertyUuid, $this->VALID_PROPERTYCITY, $this->VALID_PROPERTYCLASS, $this->VALID_PROPERTYLATITUDE, $this->VALID_PROPERTYLONGITUDE, $this->VALID_PROPERTYSTREETADDRESS, $this->VALID_PROPERTYASSESSEDVALUE);

		//insert property
		$property->insert($this->getPDO());

		//grab dah data from mySQL and check that the fields match our expectations
		$pdoProperty = Property::getPropertyByPropertyUuid($this->getPDO(), $property->getPropertyUuid());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("property"));
	}


}