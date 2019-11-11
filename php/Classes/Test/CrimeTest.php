<?php


namespace GoGitters\ApciMap\Test;

// grab the Crime Class
use GoGitters\ApciMap\{
	User, Property, Crime, Star
}; // The React Data included all the classes
use Ramsey\Uuid\Uuid; //The React Data did not include this

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
	 * max length = 13
	 * @var string $VALID_CRIMEDATE
	 */
	protected $VALID_CRIMEDATE = "1499644800000";

	/**
	 * valid latitude to use as crimeLatitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var float $VALID_CRIMELATITUDE
	 **/
	protected $VALID_CRIMELATITUDE = 35.0775992;

	/**
	 * valid longitude to use as crimeLongitude
	 * MySQL type - DECIMAL(9, 6): xxx.xxxxxx
	 * @var string $VALID_CRIMELONGITUDE
	 **/
	protected $VALID_CRIMELONGITUDE = -106.6060713;

	/**
	 * valid crime type to use as crimeType
	 * description/type of incident based on NIBRS (National Incident-Based Reporting System) used by APD
	 * max length = 134
	 **/
	protected $VALID_CRIMETYPE = "THEFT FROM A BUILDING";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		//run the default setUp() method first
		parent::setUp();
	}

	/**
	 * test inserting a valid crime incident address and verify that the actual mySQL data matches
	 **/
	public function testInsertValidCrime() : void {
		// create a new Crime report incident and insert into mySQL
		$crimeId = generateUuidV4();
		$crime = new Crime($crimeId, $this->crime->getCrimeId(), $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);
		$crime->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCrime = Crime::getCrimeByCrimeId($this->getPDO(), $crime->getCrimeId());

		$this->assertEquals($pdoCrime->getCrimeId()->toString(), $crimeId->toString());
		$this->assertEquals($pdoCrime->getCrimeAddress(), $this->VALID_CRIMEADDRESS);
		$this->assertEquals($pdoCrime->getCrimeDate(), $this->VALID_CRIMEDATE);
		$this->assertEquals($pdoCrime->getCrimeLatitude(), $this->VALID_CRIMELATITUDE);
		$this->assertEquals($pdoCrime->getCrimeLongitude(), $this->VALID_CRIMELONGITUDE);
		$this->assertEquals($pdoCrime->getCrimeType(), $this->VALID_CRIMETYPE);





		/**
		 * test inserting a valid crime incident address and verify that the actual mySQL data matches
		 **/
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("crime");

		// make a valid crime uuid
		$crimeId = generateUuidV4();

		// make a new crime incident report with valid entries
		$crime = new Crime($crimeId, $this->VALID_CRIMEADDRESS, $this->VALID_CRIMEDATE, $this->VALID_CRIMELATITUDE, $this->VALID_CRIMELONGITUDE, $this->VALID_CRIMETYPE);

		// insert a crime incident report
		$crime->insert($this->getPDO());

		// grab the data from mySQL and check that the fields match our expectations
		$pdoCrime = Crime::getCrimeByCrimeId($this->getPDO(), $crime->getCrimeId());
		$this->assertEquals($pdoCrime->getCrimeId(), $crimeId);

	}
}