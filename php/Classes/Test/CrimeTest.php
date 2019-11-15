<?php


namespace GoGitters\ApciMap\Test;

// grab the Crime Class
use GoGitters\ApciMap\{Crime};
use Ramsey\Uuid\Uuid;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Class CrimeTest
 *
 * A complete PHPUnit test of the Crime class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Crime
 * @package GoGitters\ApciMap\Test //The React Data did not include this
 * @author Lisa Lee
 **/
class CrimeTest extends ApciMapTest {

	/**
	 * valid address to use as crimeAddress
	 * neighborhood block level location of incident
	 * max length = 134
	 * @var string $VALID_CRIMEADDRESS
	 **/
	protected $VALID_CRIMEADDRESS = "8900 BLOCK LOS ARBOLES AVE NE";

	/**
	 * valid datetime to use as crime report date
	 * datetime from dataset is date that incident was reported as milliseconds since 1/1/1970 UTC (Note: This might be different to the date on which the incident took place)
	 * max length = 6
	 * @var \DateTime $VALID_CRIMEDATE
	 */
	protected $VALID_CRIMEDATE = null;

	/**
	 * valid latitude to use as crimeLatitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $VALID_CRIMELATITUDE
	 **/
	protected $VALID_CRIMELATITUDE = 35.077592;

	/**
	 * valid longitude to use as crimeLongitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $VALID_CRIMELONGITUDE
	 **/
	protected $VALID_CRIMELONGITUDE = -106.606071;

	/**
	 * content of the crime incident report
	 * valid crime type to use as crimeType
	 * description/type of incident based on NIBRS (National Incident-Based Reporting System) used by APD
	 * max length = 134
	 * @var string $VALID_CRIMETYPE
	 **/
	protected $VALID_CRIMETYPE = "THEFT FROM A BUILDING";

	/**
	 * content of the updated crime incident report
	 * max length = 134
	 * @var string $VALID_CRIMETYPE2
	 **/
	protected $VALID_CRIMETYPE2 = "AUTO THEFT";

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
	 * create dependent objects before running each test; set up function
	 **/
	public final function setUp(): void {
		//run the default setUp() method first
		parent::setUp();
		$this->VALID_CRIMEDATE = new \DateTime();
	}

	/**
	 * test inserting a valid crime report incident and verify that the actual mySQL data matches
	 *
	 * @throws \Exception
	 */
	public function testInsertValidCrime(): void {
		// create a new Crime report incident and insert into mySQL
		$crimeId = generateUuidV4();
		$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);
		$crime->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCrime = Crime::getCrimeByCrimeId($this->getPDO(), $crime->getCrimeId());

		$this->assertEquals($pdoCrime->getCrimeId()->toString(), $crimeId->toString());
		$this->assertEquals($pdoCrime->getCrimeAddress(), $this->VALID_CRIMEADDRESS);
		$this->assertEquals($pdoCrime->getCrimeDate()->getTimestamp(), $this->VALID_CRIMEDATE->getTimestamp());
		$this->assertEquals($pdoCrime->getCrimeLatitude(), $this->VALID_CRIMELATITUDE);
		$this->assertEquals($pdoCrime->getCrimeLongitude(), $this->VALID_CRIMELONGITUDE);
		$this->assertEquals($pdoCrime->getCrimeType(), $this->VALID_CRIMETYPE);
	}

	/**
	 * test inserting a crime incident report, editing it, and then updating it
	 **/
	public function testUpdateValidCrime(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("crime");

		// create a new Crime and insert it into mySQL
		$crimeId = generateUuidV4();
		$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);
		$crime->insert($this->getPDO());

		// edit the Crime and update it in mySQL
		$crime->setCrimeType($this->VALID_CRIMETYPE2);
		$crime->update($this->getPDO());

		// grab the data from mySQL and check that the fields match our expectations
		$pdoCrime = Crime::getCrimeByCrimeId($this->getPDO(), $crime->getCrimeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("crime"));
		$this->assertEquals($pdoCrime->getCrimeId(), $crimeId);
		$this->assertEquals($pdoCrime->getCrimeAddress(), $this->VALID_CRIMEADDRESS);
		$this->assertEquals($pdoCrime->getCrimeDate(), $this->VALID_CRIMEDATE);
		$this->assertEquals($pdoCrime->getCrimeLatitude(), $this->VALID_CRIMELATITUDE);
		$this->assertEquals($pdoCrime->getCrimeLongitude(), $this->VALID_CRIMELONGITUDE);
		$this->assertEquals($pdoCrime->getCrimeType(), $this->VALID_CRIMETYPE2);
	}

	/**
	 * test creating a Crime incident report and then deleting it
	 **/
	public function testDeleteValidCrime(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("crime");

		// create a new Crime and insert into mySQL
		$crimeId = generateUuidV4();
		$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);
		$crime->insert($this->getPDO());

		// delete the Crime from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("crime"));
		$crime->delete($this->getPDO());

		// grab the data from mySQL and enforce the Crime does not exist
		$pdoCrime = Crime::getCrimeByCrimeId($this->getPDO(), $crime->getCrimeId());
		$this->assertNull($pdoCrime);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("crime"));
	}

	/**
	 * test grabbing a Crime incident report that does not exist
	 **/
	public function testGetInvalidCrimeByCrimeId(): void {
		// grab a crime id that exceeds the maximum allowable crime id
		$crime = Crime::getCrimeByCrimeId($this->getPDO(), generateUuidV4());
		$this->assertNull($crime);
	}

	/**
	 * test inserting a Crime incident report and regrabbing it from mySQL
	 **/
	public function testGetValidCrimeByCrimeId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("crime");

		// create a new Crime and insert into mySQL
		$crimeId = generateUuidV4();
		$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);
		$crime->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCrime = Crime::getCrimeByCrimeId($this->getPDO(), $crime->getCrimeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("crime"));
		$this->assertEquals($pdoCrime->getCrimeId(), $crimeId);
		$this->assertEquals($pdoCrime->getCrimeAddress(), $this->VALID_CRIMEADDRESS);
		$this->assertEquals($pdoCrime->getCrimeDate(), $this->VALID_CRIMEDATE->getTimestamp());
		$this->assertEquals($pdoCrime->getCrimeLatitude(), $this->VALID_CRIMELATITUDE);
		$this->assertEquals($pdoCrime->getCrimeLongitude(), $this->VALID_CRIMELONGITUDE);
		$this->assertEquals($pdoCrime->getCrimeType(), $this->VALID_CRIMETYPE);
	}

	/**
	 * test grabbing a Crime incident report by crime type
	 **/
	public function testGetValidCrimeByCrimeType(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("crime");

		// create a new Crime and insert into mySQL
		$crimeId = generateUuidV4();
		$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);
		$crime->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Crime::getCrimeByCrimeType($this->getPDO(), $crime->getCrimeType());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("crime"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("GoGitters\ApciMap\Test", $results);

		// grab the result from the array and validate it
		$pdoCrime = $results[0];
		$this->assertEquals($pdoCrime->getCrimeId(), $crimeId);
		$this->assertEquals($pdoCrime->getCrimeAddress(), $this->VALID_CRIMEADDRESS);
		$this->assertEquals($pdoCrime->getCrimeDate(), $this->VALID_CRIMEDATE);
		$this->assertEquals($pdoCrime->getCrimeLatitude(), $this->VALID_CRIMELATITUDE);
		$this->assertEquals($pdoCrime->getCrimeLongitude(), $this->VALID_CRIMELONGITUDE);
		$this->assertEquals($pdoCrime->getCrimeType(), $this->VALID_CRIMETYPE);
	}

		/**
		 * test grabbing a Crime incident report by a crime type that does not exist
		 **/
		public function testGetInvalidCrimeByCrimeType(): void {
			// grab a crime by crime incident report type that does not exist
			$crime = Crime::getCrimeByCrimeType($this->getPDO(), "kejalek jfalek fjeio aejl");
			$this->assertCount(0, $crime);
	}

		/**
		 * test grabbing all Crimes
		 **/
		public function testGetAllValidCrimes(): void {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("crime");

			// create a new Crime and insert into mySQL
			$crimeId = generateUuidV4();
			$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);
			$crime->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$results = Crime::getAllCrimes($this->getPDO());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("crime"));
			$this->assertCount(1, $results);
			$this->assertContainsOnlyInstancesOf("GoGitters\ApciMap\Test", $results);

			// grab the result from the array and validate it
			$pdoCrime = $results[0];
			$this->assertEquals($pdoCrime->getCrimeId(), $crimeId);
			$this->assertEquals($pdoCrime->getCrimeAddress(), $this->VALID_CRIMEADDRESS);
			$this->assertEquals($pdoCrime->getCrimeDate(), $this->VALID_CRIMEDATE);
			$this->assertEquals($pdoCrime->getCrimeLatitude(), $this->VALID_CRIMELATITUDE);
			$this->assertEquals($pdoCrime->getCrimeLongitude(), $this->VALID_CRIMELONGITUDE);
			$this->assertEquals($pdoCrime->getCrimeType(), $this->VALID_CRIMETYPE);
	}

	/**
	 * test getting crime incident reports by distance
	 * @throws \Exception
	 */
	public function testGetCrimeByDistance() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("crime");

		//make a valid crime uuid
		$crimeId = generateUuidV4();

		//make a new crime incident report with valid entries
		$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);

		//insert crime incident report
		$crime->insert($this->getPDO());

		//grab data from MySQL and check expectations
		$results = Crime::getCrimeByDistance($this->getPDO(), $this->VALID_USERLATITUDE, $this->VALID_USERLONGITUDE, $this->VALID_USERDISTANCE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("crime"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("GoGitters\\ApciMap\\Property", $results);

		//grab the property from the array and validate it
		$pdoProperty = $results[0];
		$this->assertEquals($pdoCrime->getCrimeId()->toString(), $crimeId->toString());
		$this->assertEquals($pdoCrime->getCrimeAddress(), $this->VALID_CRIMEADDRESS);
		$this->assertEquals($pdoCrime->getCrimeDate(), $this->VALID_CRIMEDATE->getTimestamp());
		$this->assertEquals($pdoCrime->getCrimeLatitude(), $this->VALID_CRIMELATITUDE);
		$this->assertEquals($pdoCrime->getCrimeLongitude(), $this->VALID_CRIMELONGITUDE);
		$this->assertEquals($pdoCrime->getCrimeType(), $this->VALID_CRIMETYPE);
	}
}