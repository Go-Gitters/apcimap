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

	public function __construct($newCrimeId, $newCrimeAddress, $newCrimeDate, $newCrimeGeoLocation, $newCrimeType) {
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
	public function getCrimeId(): Uuid {
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

	public function getCrimeAddress():

	public function setCrimeAddress($newCrimeAddress): void {
		try{

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
	/**
	 * accessor method for author username
	 *
	 * @return string value of author username
	 **/
	public function getAuthorUsername(): string {
		return ($this->authorUsername);
	}
	/**
	 * mutator method for author username
	 *
	 * @param string $newAuthorUsername new value of author username
	 * @throws \InvalidArgumentException if $authorUsername is not a string or insecure
	 * @throws \RangeException if $newAuthorUsername is > 32 characters
	 * @throws \TypeError if $newAuthorUsername is not a string
	 **/
	public function setAuthorUsername(string $newAuthorUsername): void {
		// verify the that authorUsername is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("author username is empty or insecure"));
		}
		// verify the at handle will fit in the database
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("profile at handle is too large"));
		}
		// store the at userName
		$this->authorUsername = $newAuthorUsername;
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
	 * deletes this Author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE author SET authorId = :authorId, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorEmail" => $this->authorEmail, "authorUsername"];
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


	/**
	 * Gets all tweets posted on the calendar day of a given DateTime.
	 *
	 * @param \PDO $pdo The database connection object.
	 * @param DateTime $tweetDate The date on which to search for tweets.
	 * @return \SplFixedArray An array of tweet objects that match the date.
	 * @throws \PDOException MySQL errors generated by the statement.
	 **/
	public static function getTweetsByTweetDate(\PDO $pdo, DateTime $tweetDate): \SplFixedArray {

		// Create dates for midnight of the date and midnight of the next day.
		$startDateString = $tweetDate->format('Y-m-d') . ' 00:00:00';
		$startDate = new DateTime($startDateString);
		$endDate = new DateTime($startDateString);
		$endDate->add(new DateInterval('P1D'));

		// Create the query template.
		$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetDate >= :startDate AND tweetDate < :endDate";
		$statement = $pdo->prepare($query);

		// Bind the beginning and end dates to the place holder in the template.
		$parameters = [
			'startDate' => $startDate->format("Y-m-d H:i:s.u"),
			'endDate' => $endDate->format("Y-m-d H:i:s.u"),
		];
		$statement->execute($parameters);

		// Build an array of tweets from the returned rows.
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// If the row couldn't be converted, throw an exception.
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tweets);
	}
}