<?php

namespace GoGitters\ApciMap;
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *Creating a crime profile
 */
class Crime {
	use ValidateUuid;
	/**
	 * This is the crime Id.
	 * This is the primary key
	 * @var Uuid $crimeId
	 **/
	private $crimeUuid;
	/**
	 * This is the address where the crime was committed
	 */
	private $crimeAddress;
	/** This is the date that the crime occurred **/
	private $crimeDate;
	/** @var This is the latitude at which the crime was committed */
	private $crimeLatitude;
	/** @var This is the longitude at which the crime was committed */
	private $crimeLongitude;
	/**This is the type of the crime committed **/
	private $crimeType;
	private $exception;

	public function __construct($newCrimeId, $newCrimeAddress, $newCrimeDate, $newCrimeLatitiude, $newCrimeLongitude, $newCrimeType) {
		try {
			$this->setCrimeId($newCrimeId);
			$this->setCrimeAddress($newCrimeAddress);
			$this->setCrimeDate($newCrimeDate);
			$this->setCrimeLatitude($newCrimeLatitude);
			$this->crimeLongitude($newCrimeLongitude);
			$this->crimeType ($newCrimeType);
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
	 * @param Uuid| string $newCrimeId value of new crime id
	 * @throws \RangeException if $newCrimeId is not positive
	 * @throws \TypeError if the Crime Id is not
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

	public function getCrimeAddress(): string{
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

	}
/**
 * accessor method for crime date
 *
 * @return \DateTime value of crime date
 **/
	public function getCrimeDate() : \DateTime {
		return($this->crimeDate);
	}
	/**
	 * mutator method for crime date
	 *
	 * @param \DateTime|string|null $newCrimeDate crime date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newCrimeDate is not a valid object or string
	 * @throws \RangeException if $newCrimeDate is a date that does not exist
	 **/
	public function setCrimeDate($newCrimeDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newCrimeDate === null) {
			$this->crimeDate = new \DateTime();
			return;
		}

		// store the like date using the ValidateDate trait
		try {
			$newCrimeDate = self::validateDateTime($newCrimeDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->crimeDate = $newCrimeDate;
	}


public function getCrimeLatitude(): string{
	return ($this->crimeLatitude);
}
public function getCrimeLatitude(): void {
		$newCrimeLatitude = floatval()


/**
 * accessor method for crime type
 *
 * @return string value of crime type
 **/
	public function getCrimeType() : string {
		return($this->crimeType);
	}

	/**
	 * mutator method for crime type
	 *
	 * @param string $newCrimeType new value of crime type
	 * @throws \InvalidArgumentException if $newCrimeType is not a string or insecure
	 * @throws \RangeException if $newCrimeType is > 134 characters
	 * @throws \TypeError if $newCrimeType is not a string
	 **/
	public function setCrimeType(string $newCrimeType) : void {
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
	 * inserts this Author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO crime(crimeUuid, crimeAddress, crimeDate, crimeGeolocation) VALUES(:crimeUuid, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :AuthorUsername)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["crimeUuid" => $this->crimeUuid->getBytes(), "crimeAddress" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
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
		$parameters = ["crimeUuid" => $this->crimeUuid->getBytes(), "crimeAddress" => $this->crimeAddress->getBytes(), "authorEmail" => $this->authorEmail, "authorUsername"];
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
		$crime = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$crime = new Crime($row["crimeUuid"], $row["crimeAddress"], $row["crimeDate"], $row["crimeLatitude"], $row["crimeLongitude"], $row["crimeType"]);
				$crimes[$crimes->key()] = $crime;
				$crime->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(invalid), 0, $exception));
			}
		}
		return ($crime);
	}
	/**
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
		$crime = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$crime = new Crime($row["crimeUuid"], $row[crimeAddress], $row["crimeDate"], $row["crimeLatitude"], $row[crimeLongitude], $row["crimeType"]);
				$crime[$crimes->key()] = $crime;
				$crime->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($crimes);
	}

}