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
 * A PHPUnit test of the Property class
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
	 * valid assessed value to use as propertyValue
	 * assessed value for this property
	 * MySQL type - DECIMAL(15, 2)
	 * @var float $VALID_PROPERTYVALUE
	 **/
	protected $VALID_PROPERTYVALUE = "5096837.87";

	/**
	 * second valid assessed value to use as propertyValue
	 * assessed value for this property
	 * MySQL type - DECIMAL(15, 2)
	 * @var float $VALID_PROPERTYVALUE2
	 **/
	protected $VALID_PROPERTYVALUE2 = "8457.25";

	/**
	 * valid user latitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $VALID_USERLATITUDE
	 **/
	protected $VALID_USERLATITUDE = 35.093863;

	/**
	 * valid user longitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $VALID_USERLONGITUDE
	 **/
	protected $VALID_USERLONGITUDE = -106.640397;

	/**
	 * valid user distance
	 * distance in miles that the user is searching by
	 * @var float $VALID_USERDISTANCE
	 **/
	protected $VALID_USERDISTANCE= 10.0;

	/**
	 * setup function
	 **/
	public final function setUp() : void {
		parent::setUp();
	}

	/**
	 * Test inserting a valid property.  This also tests getPropertyByPropertyId().
	 **/
	public function testInsertValidProperty() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("property");

		//make a valid property uuid
		$propertyId = generateUuidV4();

		//make a new property with valid entries
		$property = new Property($propertyId, $this->VALID_PROPERTYCITY, $this->VALID_PROPERTYCLASS, $this->VALID_PROPERTYLATITUDE, $this->VALID_PROPERTYLONGITUDE, $this->VALID_PROPERTYSTREETADDRESS, $this->VALID_PROPERTYVALUE);

		//insert property
		$property->insert($this->getPDO());

		//grab dah data from mySQL and check that the fields match our expectations
		$pdoProperty = Property::getPropertyByPropertyId($this->getPDO(), $property->getPropertyId());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("property"));
		$this->assertEquals($pdoProperty->getPropertyId()->toString(), $propertyId->toString());
		$this->assertEquals($pdoProperty->getPropertyCity(), $this->VALID_PROPERTYCITY);
		$this->assertEquals($pdoProperty->getPropertyClass(), $this->VALID_PROPERTYCLASS);
		$this->assertEquals($pdoProperty->getPropertyLatitude(), $this->VALID_PROPERTYLATITUDE);
		$this->assertEquals($pdoProperty->getPropertyLongitude(), $this->VALID_PROPERTYLONGITUDE);
		$this->assertEquals($pdoProperty->getPropertyStreetAddress(), $this->VALID_PROPERTYSTREETADDRESS);
		$this->assertEquals($pdoProperty->getPropertyValue(), $this->VALID_PROPERTYVALUE);
	}


	/**
	 * Test updating valid property.
	 *
	 * @throws \Exception
	 */
	public function testUpdateValidProperty() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("property");

		//make a valid property uuid
		$propertyId = generateUuidV4();

		//make a new property with valid entries
		$property = new Property($propertyId, $this->VALID_PROPERTYCITY, $this->VALID_PROPERTYCLASS, $this->VALID_PROPERTYLATITUDE, $this->VALID_PROPERTYLONGITUDE, $this->VALID_PROPERTYSTREETADDRESS, $this->VALID_PROPERTYVALUE);

		//insert property
		$property->insert($this->getPDO());

		//edit the property and update it in MySQL
		$property->setPropertyValue($this->VALID_PROPERTYVALUE2);
		$property->update($this->getPDO());

		//grab dah data from mySQL and check that the fields match our expectations
		$pdoProperty = Property::getPropertyByPropertyId($this->getPDO(), $property->getPropertyId());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("property"));
		$this->assertEquals($pdoProperty->getPropertyId()->toString(), $propertyId->toString());
		$this->assertEquals($pdoProperty->getPropertyCity(), $this->VALID_PROPERTYCITY);
		$this->assertEquals($pdoProperty->getPropertyClass(), $this->VALID_PROPERTYCLASS);
		$this->assertEquals($pdoProperty->getPropertyLatitude(), $this->VALID_PROPERTYLATITUDE);
		$this->assertEquals($pdoProperty->getPropertyLongitude(), $this->VALID_PROPERTYLONGITUDE);
		$this->assertEquals($pdoProperty->getPropertyStreetAddress(), $this->VALID_PROPERTYSTREETADDRESS);
		$this->assertEquals($pdoProperty->getPropertyValue(), $this->VALID_PROPERTYVALUE2);
	}

	/**
	 * Test creating a property and then deleting it testDeleteValidProperty()
	 *
	 * @throws \Exception
	 */
	public function testDeleteValidProperty() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("property");

		//make a valid property uuid
		$propertyId = generateUuidV4();

		//make a new property with valid entries
		$property = new Property($propertyId, $this->VALID_PROPERTYCITY, $this->VALID_PROPERTYCLASS, $this->VALID_PROPERTYLATITUDE, $this->VALID_PROPERTYLONGITUDE, $this->VALID_PROPERTYSTREETADDRESS, $this->VALID_PROPERTYVALUE);

		//insert property
		$property->insert($this->getPDO());

		//test number of rows then delete the property from MySQL
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("property"));
		$property->delete($this->getPDO());

		//grab the data from MySQL and test that the property does not exist
		$pdoProperty = Property::getPropertyByPropertyId($this->getPDO(), $property->getPropertyId());
		$this->assertNull($pdoProperty);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("property"));
	}

	/**
	 * Test grabbing a property that does not exist testGetInvalidPropertyByPropertyId()
	 **/
	public function testGetInvalidPropertyByPropertyId() : void {
		//make a propertyId that is not in MySQL
		$propertyId = generateUuidV4();
		//get property by new Id
		$pdoProperty = Property::getPropertyByPropertyId($this->getPDO(), $propertyId);
		$this->assertNull($pdoProperty);
	}

	/**
	 * Test getting all properties
	 * @throws \Exception
	 */

	public function testGetAllProperties() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("property");

		//make a valid property uuid
		$propertyId = generateUuidV4();

		//make a new property with valid entries
		$property = new Property($propertyId, $this->VALID_PROPERTYCITY, $this->VALID_PROPERTYCLASS, $this->VALID_PROPERTYLATITUDE, $this->VALID_PROPERTYLONGITUDE, $this->VALID_PROPERTYSTREETADDRESS, $this->VALID_PROPERTYVALUE);

		//insert property
		$property->insert($this->getPDO());

		//grab data from MySQL and check expectations
		$results = Property::getAllProperties($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("property"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("GoGitters\\ApciMap\\Property", $results);

		//grab the property from the array and validate it
		$pdoProperty = $results[0];
		$this->assertEquals($pdoProperty->getPropertyId()->toString(), $propertyId->toString());
		$this->assertEquals($pdoProperty->getPropertyCity(), $this->VALID_PROPERTYCITY);
		$this->assertEquals($pdoProperty->getPropertyClass(), $this->VALID_PROPERTYCLASS);
		$this->assertEquals($pdoProperty->getPropertyLatitude(), $this->VALID_PROPERTYLATITUDE);
		$this->assertEquals($pdoProperty->getPropertyLongitude(), $this->VALID_PROPERTYLONGITUDE);
		$this->assertEquals($pdoProperty->getPropertyStreetAddress(), $this->VALID_PROPERTYSTREETADDRESS);
		$this->assertEquals($pdoProperty->getPropertyValue(), $this->VALID_PROPERTYVALUE);

	}

	/**
	 * Test getting properties by distance
	 * @throws \Exception
	 */

	public function testGetPropertyByDistance() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("property");

		//make a valid property uuid
		$propertyId = generateUuidV4();

		//make a new property with valid entries
		$property = new Property($propertyId, $this->VALID_PROPERTYCITY, $this->VALID_PROPERTYCLASS, $this->VALID_PROPERTYLATITUDE, $this->VALID_PROPERTYLONGITUDE, $this->VALID_PROPERTYSTREETADDRESS, $this->VALID_PROPERTYVALUE);

		//insert property
		$property->insert($this->getPDO());

		//grab data from MySQL and check expectations
		$results = Property::getPropertyByDistance($this->getPDO(), $this->VALID_USERLATITUDE, $this->VALID_PROPERTYLONGITUDE, $this->VALID_USERDISTANCE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("property"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("GoGitters\\ApciMap\\Property", $results);

		//grab the property from the array and validate it
		$pdoProperty = $results[0];
		$this->assertEquals($pdoProperty->getPropertyId()->toString(), $propertyId->toString());
		$this->assertEquals($pdoProperty->getPropertyCity(), $this->VALID_PROPERTYCITY);
		$this->assertEquals($pdoProperty->getPropertyClass(), $this->VALID_PROPERTYCLASS);
		$this->assertEquals($pdoProperty->getPropertyLatitude(), $this->VALID_PROPERTYLATITUDE);
		$this->assertEquals($pdoProperty->getPropertyLongitude(), $this->VALID_PROPERTYLONGITUDE);
		$this->assertEquals($pdoProperty->getPropertyStreetAddress(), $this->VALID_PROPERTYSTREETADDRESS);
		$this->assertEquals($pdoProperty->getPropertyValue(), $this->VALID_PROPERTYVALUE);

	}
	//TODO: Test getPropertyByUserId


}