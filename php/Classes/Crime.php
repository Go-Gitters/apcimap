<?php

namespace GoGitters\ApciMap;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *Creating a crime profile
 * @author Lindsey Atencio
 * @version 0.0.1
 *
 **/
class Crime {
	use ValidateUuid;
	/**
	 * This is the crime Id.
	 * This is the primary key
	 * @var Uuid $crimeUuid
	 **/
	private $crimeUuid;
	/**
	 * This is the address where the police report was filed
	 */
	private $crimeAddress;
	/**
	 * This is the date that the crime report occurred
	 * @var
	 */
	private $crimeDate;
	/** @var
	 * This is the latitude at which the crime report occurred
	 */
	private $crimeLatitude;
	/**
	 * This is the longitude at which the crime report occurred
	 * @var float $crimeLongitude
	 */
	private $crimeLongitude;
	/**
	 * @var string $crimeType
	 * This is the type of crime reported *
	 */
	private $crimeType;

	/**
	 * Crime constructor.
	 * @param $newCrimeId
	 * @param $newCrimeAddress
	 * @param $newCrimeDate
	 * @param $newCrimeLatitude
	 * @param $newCrimeLongitude
	 * @param $newCrimeType
	 */
	/*todo add to the above and add the name of each section above like they did in theirs*/
	public function __construct($newCrimeUuid, $newCrimeAddress, $newCrimeDate, $newCrimeLatitude, $newCrimeLongitude, $newCrimeType) {
		try {
			$this->setCrimeUuid($newCrimeUuid);
			$this->setCrimeAddress($newCrimeAddress);
			$this->setCrimeDate($newCrimeDate);
			$this->setCrimeLatitude($newCrimeLatitude);
			$this->setCrimeLongitude($newCrimeLongitude);
			$this->setCrimeType($newCrimeType);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for crime id
	 *
	 * @return Uuid value of crime id (or null if new Crime)
	 **/
	public function getCrimeUuid(): Uuid {
		return ($this->crimeUuid);
	}

	/**
	 * mutator method for crime id
	 *
	 * @param Uuid| string $newCrimeUuid value of new crime id
	 * @throws \RangeException if $newCrimeUuid is not positive
	 * @throws \TypeError if the Crime Id is not positive
	 **/
	public function setCrimeUuid($newCrimeUuid): void {
		try {
			$uuid = self::validateUuid($newCrimeUuid);
			//determine what exception type was thrown
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->crimeUuid = $uuid;
	}

	public function getCrimeAddress(): string {
		return ($this->crimeAddress);
	}

	public function setCrimeAddress(string $newCrimeAddress): void {
		$newCrimeAddress = trim($newCrimeAddress);
		$newCrimeAddress = filter_var($newCrimeAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCrimeAddress) === true) {
			throw(new \InvalidArgumentException("crime address is empty or invalid"));
		}
		if(strlen($newCrimeAddress) > 134) {
			throw(new \RangeException("crime address is too long"));
		}
		// store the crime address
		$this->crimeAddress = $newCrimeAddress;
	}

	/**
	 * accessor method for crime date
	 *
	 * @return \DateTime value of crime date
	 **/
	public function getCrimeDate(): \DateTime {
		return ($this->crimeDate);
	}

	/**
	 * mutator method for crime date
	 *
	 * @param \DateTime|string|null $newCrimeDate crime date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newCrimeDate is not a valid object or string
	 * @throws \RangeException if $newCrimeDate is a date that does not exist
	 **/
	public function setCrimeDate(string $newCrimeDate): void {
		// store the like date using the ValidateDate trait
		try {
			$newCrimeDate = self::validateDateTime($newCrimeDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->crimeDate = $newCrimeDate;
	}
/* todo reformat the above to match string validation not date*/
	/**
	 * accessor method for crime latitude
	 *
	 * @return float value of crime type
	 **/
	public function getCrimeLatitude(): float {
		return ($this->crimeLatitude);
	}
	/**mutator method for crime latitude
	 * @param float $newCrimeLatitude latitude for this crime report
	 * @throws \TypeError if $newCrimeLatitude is not a float
	 * @throws \InvalidArgumentException if latitude is outside of the ranges of -90 and 90
	 * */
	/*todo look at other documentation for adding variables in data design*/
	public function setCrimeLatitude(float $newCrimeLatitude): void {
		if(!($newCrimeLatitude >= -90) && ($newCrimeLatitude <= 90)) {
			throw(new \InvalidArgumentException("latitude must be between -90 and 90"));
		}
		$newCrimeLatitude = round($newCrimeLatitude, 6);
		$this->crimeLatitude = $newCrimeLatitude;
	}

	/**accessor method for crime longitude
	 * @return float value of crime type
	 **/
	public function getCrimeLongitude(): float {
		return ($this->crimeLongitude);
	}

	/**mutator method for crime longitude
	 * @throws \InvalidArgumentException if longitude is outside of the ranges of -180 and 180
	 * */
	public function setCrimeLongitude(float $newCrimeLongitude): void {
		if(!($newCrimeLongitude >= -180) && ($newCrimeLongitude <= 180)) {
			throw(new \InvalidArgumentException("longitude must be between -180 and 180"));
		}
		$newCrimeLongitude = round($newCrimeLongitude, 6);
		$this->crimeLongitude = $newCrimeLongitude;
	}

	/**
	 * accessor method for crime type
	 *
	 * @return string value of crime type
	 **/
	public function getCrimeType(): string {
		return ($this->crimeType);
	}

	/**
	 * mutator method for crime type
	 *
	 * @param string $newCrimeType new value of crime type
	 * @throws \InvalidArgumentException if $newCrimeType is not a string or insecure
	 * @throws \RangeException if $newCrimeType is > 134 characters
	 * @throws \TypeError if $newCrimeType is not a string
	 **/
	public function setCrimeType(string $newCrimeType): void {
		// verify the crime type is secure
		$newCrimeType = trim($newCrimeType);
		$newCrimeType = filter_var($newCrimeType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCrimeType) === true) {
			throw(new \InvalidArgumentException("crime type is empty or insecure"));
		}

		// verify the crime type will fit in the database
		if(strlen($newCrimeType) > 134) {
			throw(new \RangeException("crime type description too large"));
		}

		// store the crime content
		$this->crimeType = $newCrimeType;
	}


	/**
	 * inserts this Crime into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO crime(crimeUuid, crimeAddress, crimeDate, crimeLatitude, crimeLongitude, crimeType) VALUES(:crimeUuid, :crimeAddress, :crimeDate, :crimeLatitude, :crimeLongitude, :crimeType)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["crimeUuid" => $this->crimeUuid->getBytes(), "crimeAddress" => $this->crimeAddress, "crimeDate" => $this->crimeDate, "crimeLatitude" => $this->crimeLatitude, "crimeLongitude" => $this->crimeLongitude, "crimeType" =>$this->crimeType];
		$statement->execute($parameters);
	}

	/**
	 * deletes this crime from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM crime WHERE crimeUuid = :crimeUuid";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["crimeUuid" => $this->crimeUuid->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Crime in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE crime SET crimeUuid = :crimeUuid, crimeAddress = :crimeAddress, crimeDate = :crimeDate, crimeLatitude = :crimeLatitude, crimeLongitude = :crimeLongitude, crimeType = :crimeType WHERE crimeUuid = :crimeUuid";
		$statement = $pdo->prepare($query);
		$parameters = ["crimeUuid" => $this->crimeUuid->getBytes(), "crimeAddress" => $this->crimeAddress, "crimeLatitude" => $this->crimeLatitude, "crimeLongitude" =>$this->crimeLongitude, "crimeType" => $this->crimeType];
		$statement->execute($parameters);
	}

	/**
	 * gets the Crime by crime uuid
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $crimeUuid crime id to search by
	 * @return \SplFixedArray SplFixedArray of Crimes found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCrimeByCrimeUuid(\PDO $pdo, $crimeUuid): \SplFixedArray {
		try {
			$crimeUuid = self::validateUuid($crimeUuid);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT crimeUuid, crimeAddress, crimeDate, crimeLatitude, crimeLongitude, crimeType From: crimeUuid WHERE crimeUuid = :crimeUuid";
		$statement = $pdo->prepare($query);
		// bind the crime uuid to the place holder in the template
		$parameters = ["crimeUuid" => $crimeUuid->getBytes()];
		$statement->execute($parameters);
		// build an array of crimes
		$crimes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$crime = new Crime($row["crimeUuid"], $row["crimeAddress"], $row["crimeDate"], $row["crimeLatitude"], $row["crimeLongitude"], $row["crimeType"]);
				$crimes[$crimes->key()] = $crime;
				$crimes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($crimes);
	}

	/**o
	 * gets all Crimes
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Crimes found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllCrimes(\PDO $pdo): \SPLFixedArray {
		// create query template
		$query = "SELECT crimeUuid, crimeAddress, crimeDate, crimeLatitude, crimeLongitude, crimeType  FROM crime";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of crimes
		$crimes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$crime = new Crime($row["crimeUuid"], $row["crimeAddress"], $row["crimeDate"], $row["crimeLatitude"], $row["crimeLongitude"], $row["crimeType"]);
				$crimes[$crimes->key()] = $crime;
				$crimes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($crimes);
	}

}