<?php

namespace GoGitters\ApciMap;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 *Creating a crime profile
 * @author Lindsey Atencio
 * @version 0.0.1
 *the crime class has information such as the crime report location, type of crime, and date of crime.
 **/
class Crime implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/********************************************
	 * Declare and document all state variables *
	 ********************************************/
	use ValidateUuid;
	/**
	 * This is the crime Id.
	 * This is the primary key
	 * @var Uuid $crimeId
	 **/
	private $crimeId;
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
	/********************************************
	 * Constructor method                  *
	 ********************************************/
	/**
	 * Crime constructor.
	 * @param string| Uuid $newCrimeId of this crime
	 * @param string $newCrimeAddress address at which the crime report was filed
	 * @param string $newCrimeDate date at which the crime report was filed
	 * @param float $newCrimeLatitude latitude of the location the crime report was filed
	 * @param float $newCrimeLongitude longitude of the location the crime report was filed
	 * @param string $newCrimeType type of crime reported
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct($newCrimeId, $newCrimeAddress, $newCrimeDate, $newCrimeLatitude, $newCrimeLongitude, $newCrimeType) {
		try {
			$this->setCrimeId($newCrimeId);
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
	 * @return Uuid value of crime id (or null if new Crime)
	 **/
	public function getCrimeId(): Uuid {
		return ($this->crimeId);
	}
	/**
	 * mutator method for crime id
	 * @param Uuid| string $newCrimeId value of new crime id
	 * @throws \RangeException if $newCrimeId is not positive
	 * @throws \TypeError if the Crime Id is not a uuid or a string
	 **/
	public function setcrimeId($newCrimeId): void {
		try {
			$uuid = self::validateUuid($newCrimeId);
			//determine what exception type was thrown
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->crimeId = $uuid;
	}
	/**
	 * accessor method for crime report address
	 * @return Uuid value of crime report address (or null if new Crime)
	 **/
	public function getCrimeAddress(): string {
		return ($this->crimeAddress);
	}
	/**
	 * mutator method for crime address
	 * @param string $newCrimeAddress value of new crime address
	 * @throws \RangeException if $newCrimeAddress is empty or not valid
	 * @throws \TypeError if the Crime Address is greater than 134 characters
	 **/
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
	 * accessor method for the crime report date
	 * @return string crime date
	 **/
	public function getCrimeDate(): \DateTime {
		return ($this->crimeDate);
	}
	/**
	 * mutator method for crime date
	 * @param \DateTime|string|null $newCrimeDate like date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newCrimeDate is not a valid object or string
	 * @throws \RangeException if $newCrimeDate is a date that does not exist
	 **/
	public function setCrimeDate(string $newCrimeDate): void {
		// base case: if the date is null, use the current date and time
		if($newCrimeDate === null) {
			$this->crimeDate = new \DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newCrimeDate = self::validateDate($newCrimeDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->crimeDate = $newCrimeDate;
	}
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
	public function setCrimeLatitude(float $newCrimeLatitude): void {
		if(!($newCrimeLatitude >= -90) && ($newCrimeLatitude <= 90)) {
			throw(new \InvalidArgumentException("latitude must be between -90 and 90"));
		}
		$newCrimeLatitude = round($newCrimeLatitude, 6);
		$this->crimeLatitude = $newCrimeLatitude;
	}

	/**accessor method for crime longitude
	 * @return float value of crime longitude
	 **/
	public function getCrimeLongitude(): float {
		return ($this->crimeLongitude);
	}

	/**
	 * mutator method for crime report longitude
	 * @param float $newCrimeLongitude longitude of this crime report
	 * @throws \InvalidArgumentException if $newCrimeLongitude is not >= -180 and <=180
	 * @throws \TypeError if $newCrimeLongitude is not a float
	 **/
	public function setCrimeLongitude(float $newCrimeLongitude): void {
		if(!($newCrimeLongitude >= -180) && ($newCrimeLongitude <= 180)) {
			throw(new \InvalidArgumentException("longitude must be between -180 and 180"));
		}
		$newCrimeLongitude = round($newCrimeLongitude, 6);
		$this->crimeLongitude = $newCrimeLongitude;
	}
	/**
	 * accessor method for crime type
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
		$query = "INSERT INTO crime(crimeId, crimeAddress, crimeDate, crimeLatitude, crimeLongitude, crimeType) VALUES(:crimeId, :crimeAddress, :crimeDate, :crimeLatitude, :crimeLongitude, :crimeType)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->crimeDate->format("Y-m-d H:i:s.u");
		$parameters = ["crimeId" => $this->crimeId->getBytes(), "crimeAddress" => $this->crimeAddress, "crimeDate" => $formattedDate, "crimeLatitude" => $this->crimeLatitude, "crimeLongitude" => $this->crimeLongitude, "crimeType" =>$this->crimeType];
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
		$query = "DELETE FROM crime WHERE crimeId = :crimeId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["crimeId" => $this->crimeId->getBytes()];
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
		$query = "UPDATE crime SET crimeId = :crimeId, crimeAddress = :crimeAddress, crimeDate = :crimeDate, crimeLatitude = :crimeLatitude, crimeLongitude = :crimeLongitude, crimeType = :crimeType WHERE crimeId = :crimeId";
		$statement = $pdo->prepare($query);
		$parameters = ["crimeId" => $this->crimeId->getBytes(), "crimeAddress" => $this->crimeAddress, "crimeLatitude" => $this->crimeLatitude, "crimeLongitude" =>$this->crimeLongitude, "crimeType" => $this->crimeType];
		$statement->execute($parameters);
	}

	/**
	 * gets the Crime by crime uuid
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $crimeId crime id to search by
	 * @return \SplFixedArray SplFixedArray of Crimes found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCrimeBycrimeId(\PDO $pdo, $crimeId): \SplFixedArray {
		try {
			$crimeId = self::validateUuid($crimeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT crimeId, crimeAddress, crimeDate, crimeLatitude, crimeLongitude, crimeType From: crimeId WHERE crimeId = :crimeId";
		$statement = $pdo->prepare($query);
		// bind the crime uuid to the place holder in the template
		$parameters = ["crimeId" => $crimeId->getBytes()];
		$statement->execute($parameters);
		// build an array of crimes
		$crime = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$crime = new Crime($row["crimeId"], $row["crimeAddress"], $row["crimeDate"], $row["crimeLatitude"], $row["crimeLongitude"], $row["crimeType"]);
				$crime[$crime->key()] = $crime;
				$crime->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($crime);
	}
	/**
	 * gets the Crime by distance
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param float $crimeLatitude latitude coordinate of where crime report occurred
	 * @param float $crimeLongitude longitude coordinate of where crime report occurred
	 * @param float $distance distance in miles that the user is searching by
	 * @return \SplFixedArray SplFixedArray of crimes found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * **/
	public static function getCrimeByDistance(\PDO $pdo, float $crimeLatitude, float $crimeLongitude, float $distance) : \SplFixedArray {
		// create query template
		$query = "SELECT crimeId, crimeAddress, crimeDate, crimeLatitude, crimeLongitude, crimeType FROM crime WHERE haversine(:crimeLatitude, :crimeLongitude, crimeLatitude, crimeLongitude) < :distance";
		$statement = $pdo->prepare($query);
		// bind the crime distance to the place holder in the template
		$parameters = ["distance" => $distance, "crimeLatitude" => $crimeLatitude, "crimeLongitude" => $crimeLongitude];
		$statement->execute($parameters);
		// build an array of crimes
		$crime = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$crime = new Crime($row["crimeId"], $row["crimeAddress"], $row["crimeDate"], $row["crimeLatitude"], $row["crimeLongitude"], $row["crimeType"]);
				$crimes[$crimes->key()] = $crime;
				$crimes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($crimes);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["crimeId"] = $this->crimeId->toString();
		return ($fields);
		//format the date so that the front end can consume it
		$fields["crimeDate"] = round(floatval($this->crimeDate->format("U.u")) * 1000);
		return($fields);
	}
}