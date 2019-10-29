<?php

namespace latencio23\crim;
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
	private $crimeId;
	/**
	 * This is the address where the crime was committed
	 */
	private $crimeAddress;
	/** This is the date that the crime occurred **/
	private $crimeDate;
	/** This is the geo-location of the crime * */
	private $crimeGeoLocation;
	/**This is the type of the crime committed **/
	private $crimeType;
	private $exception;

	public function __construct($newCrimeId, $newCrimeAddress, $newCrimeDate, $newCrimeGeoLocation, $newCrimeType) {
		try {
			$this->setCrimeId($newCrimeId);
			$this->setCrimeAddress($newCrimeAddress);
			$this->setCrimeDate($newCrimeDate);
			$this->setCrimeGeoLocation($newcrimeGeoLocation);
			$this->crimeType($newCrimeType);
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
		return ($this->crimeId);
	}

	/**
	 * mutator method for crime id
	 *
	 * @param Uuid| string $newCrimeId value of new crime id
	 * @throws \RangeException if $newCrimeId is not positive
	 * @throws \TypeError if the Crime Id is not
	 **/
	public function setCrimeId($newCrimeId): void {
		try {
			$uuid = self::validateUuid($newCrimeId);
			//determine what exception type was thrown
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->crimeId = $uuid;
	}

	public function getCrimeAddress():

	public function setCrimeAddress($newCrimeAddress): void {
		try:

	}
	/**
	 * accessor method for author avatar url
	 *
	 * @return url value of the activation token
	 */

	 * accessor method for author email
	 *
	 * @return string value of author email
	 **/
	public function getAuthorEmail() {
		return ($this->authorEmail);
	}
	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setAuthorEmail($newAuthorEmail): void {
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("Invalid Email"));
		}
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("Email has too many characters"));
		}
		$this->authorEmail = $newAuthorEmail;
	}
	/**
	 * accessor method for authorHash
	 *
	 * @return string value of hash
	 */
	public function getAuthorHash() {
		return ($this->authorHash);
	}
	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 97 characters
	 * @throws \TypeError if profile ha
	 * sh is not a string
	 */
	public function setAuthorHash($newAuthorHash): string {
		$newAuthorHash = trim($newAuthorHash);
		if(empty ($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("Hash is empty or invalid"));
		}
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("authorHash has too many characters"));
		}
		$this->authorHash = $newAuthorHash;
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
		$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES(:AuthorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :AuthorUsername)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
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
	 * gets the Author by author id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Authors found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId): \SplFixedArray {
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorEmail, authorUsername From: authorId WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		// bind the author profile id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);
		// build an array of author
		$author = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row[authorActivationtoken], $row["authorAvatarUrl"], $row["authorEmail"], $row[authorHash], $row["authorUsername"]);
				$authors[$authors->key()] = $author;
				$author->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(invalid), 0, $exception));
			}
		}
		return ($author);
	}
	/**
	 * gets all Authors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Authors found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAuthors(\PDO $pdo): \SPLFixedArray {
		// create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername  FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of authors
		$author = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row[authorActivationToken], $row["authorAvatarUrl"], $row["authorEmail"], $row[authorHash], $row["authorUsername"]);
				$authors[$authors->key()] = $author;
				$author->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
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