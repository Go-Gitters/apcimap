<?php


namespace GoGitters\ApciMap\Test;

//grab the Property Class
use GoGitters\ApciMap\{Property, User, Star};
use Ramsey\Uuid\Uuid;

require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Class StarTest
 *
 * A complete PHPUnit test of the Star class.  It is complete because *ALL* mySQL/PDO enabled methods are tested for
 * both valid and invalid inputs
 *
 * @see Property
 * @package GoGitters\ApciMap\Test
 *
 * @author Lisa Lee
 */


class StarTest extends ApciMapTest {

	/**
	 * User that starred the Property; this is for foreign key relations
	 * @var User $user
	 **/
	protected $user;

	/**
	 * Property that was starred; this is for foreign key relations
	 * @var Property $property
	 **/
	protected $property;

	/**
	 * valid user hash to use
	 * @var $VALID_USERHASH
	 **/
	protected $VALID_USERHASH;

	/**
	 * valid user activationToken to create the user object to own the test
	 * @var string $VALID_USERACTIVATIONTOKEN
	 **/
	protected $VALID_USERACTIVATIONTOKEN;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();

		// create a salt and hash for the mocked user
		$password = "password123";
		$this->VALID_USERHASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_USERACTIVATIONTOKEN = bin2hex(random_bytes(16));

		// create and insert the mocked user
		$this->user = new User(generateUuidV4(), null, "@phpunit", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_USERHASH, "+12125551212");
		$this->user->insert($this->getPDO());

		// create and insert the mocked property
		$this->property = new Property(generateUuidV4(), $this->user->getUserId(), "PHPUnit star test passing");
		$this->property->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Star and verify that the actual mySQL data matches
	 **/
	public function testInsertValidStar() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("star");

		// create a new Star and insert into mySQL
		$star = new Star($this->user->getUserId(), $this->property->getPropertyId());
		$star->insert($this->getPDO());

		// grab the data from mySQL and enforce that the fields match our expectations
		$pdoStar = Star::getStarByStarPropertyIdAndStarUserId($this->getPDO(), $this->user->getUserId(), $this->property->getPropertyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("star"));
		$this->assertEquals($pdoStar->getStarUserId(), $this->user->getUserId());
		$this->assertEquals($pdoStar->getStarPropertyId(), $this->property->getPropertyId());
	}

	/**
	 * test creating a Star and then deleting it
	 **/
	public function testDeleteValidStar() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("star");

		// create a new Star and insert into mySQL
		$star = new Star($this->user->getUserId(), $this->property->getPropertyId());
		$star->insert($this->getPDO());

		// delete the Star from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("star"));
		$star->delete($this->getPDO());

		// grab the data from mySQL and enforce the Property does not exist
		$pdoStar = Star::getStarByStarPropertyIdAndStarUserId($this->getPDO(), $this->user->getUserId(), $this->property->getPropertyId());
		$this->assertNull($pdoStar);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("star"));
	}

	/**
	 * test inserting a Star and regrabbing it from mySQL
	 **/
	public function testGetValidStarByPropertyIdAndUserId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("star");

		// create a new Star and insert into mySQL
		$star = new Star($this->user->getUserId(), $this->property->getPropertyId());
		$star->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoStar = Star::getStarByStarPropertyIdAndStarUserId($this->getPDO(), $this->user->getUserId(), $this->property->getPropertyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("star"));
		$this->assertEquals($pdoStar->getStarUserId(), $this->user->getUserId());
		$this->assertEquals($pdoStar->getStarPropertyId(), $this->property->getPropertyId());
	}

	/**
	 * test grabbing a Star that does not exist
	 **/
	public function testGetInvalidStarByPropertyIdAndUserId() {
		// grab a property id and user id that exceeds the maximum allowable property id and user id
		$star = Star::getStarByStarPropertyIdAndStarUserId($this->getPDO(), generateUuidV4());
		$this->assertNull($star);
	}

	/**
	 * test grabbing a Star by property id
	 **/
	public function testGetValidStarByPropertyId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("star");

		// create a new Star and insert to into mySQL
		$star = new Star($this->user->getUserId(), $this->property->getPropertyId());
		$star->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Star::getStarByStarPropertyId($this->getPDO(), $this->property->getPropertyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("star"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("GoGitters\\ApciMap\\Star", $results);

		// grab the result from the array and validate it
		$pdoStar = $results[0];
		$this->assertEquals($pdoStar->getStarUserId(), $this->user->getUserId());
		$this->assertEquals($pdoStar->getStarPropertyId(), $this->property->getPropertyId());
	}

	/**
	 * test grabbing a Star by a property id that does not exist
	 **/
	public function testGetInvalidStarByPropertyId() : void {
		// grab a property id that exceeds the maximum allowable property id
		$star = Star::getStarByStarPropertyId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $star);
	}

}


