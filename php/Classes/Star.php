<?php


namespace GoGitters\ApciMap;
require_once("autoload.php");

require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/*
 * Star Class
 *
 * This class includes data for starPropertyId and starUserId.
 *
 * @author Lisa Lee
 * @version 0.0.1
 */

class Star Implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id of the Property being starred; this is a component of a composite primary key (and a foreign key)
	 * @var Uuid $starPropertyId
	 */
	private $starPropertyId;

	/**
	 * id of the User who starred; this is a component of a composite primary key (and a foreign key)
	 * @var Uuid $starUserId
	 */
	private $starUserId;

	/********************************************
	 * Constructor                              *
	 ********************************************/
	/**
	 * constructor for this Star
	 *
	 * @param string|Uuid $newStarPropertyId id of the parent Property
	 * @param string|Uuid $newStarUserId id of the parent User
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct($newStarPropertyId, $newStarUserId) {
		// use the mutator methods to do the work for us
		try {
			$this->setStarPropertyId($newStarPropertyId);
			$this->setStarUserId($newStarUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			// determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/********************************************
	 * Getters and Setters                      *
	 ********************************************/

	/**
	 * accessor method for property id
	 *
	 * @return Uuid value of property id
	 */
	public function getStarPropertyId(): Uuid {
		return ($this->starPropertyId);
	}

	/**
	 * mutator method for Property id
	 *
	 * @param Uuid|string $newStarPropertyId new value of property id
	 * @throws \RangeException if $newStarPropertyId is not positive
	 * @throws \TypeError if $newStarPropertyId is not a uuid or string
	 */
	public function setStarPropertyId($newStarPropertyId): void {
		try {
			$newStarPropertyId = self::validateUuid($newStarPropertyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the starred property id
		$this->starPropertyId = $newStarPropertyId;
	}

	/**
	 * accessor method for user id
	 *
	 * @return Uuid value of user id
	 */
	public function getStarUserId(): Uuid {
		return ($this->starUserId);
	}

	/**
	 * mutator method for user id
	 *
	 * @param Uuid|string $newStarUserId new value of user id
	 * @throws \RangeException if $newStarUserId is not positive
	 * @throws \TypeError if $newStarUserId is not a uuid or string
	 */
	public function setStarUserId($newStarUserId): void {
		try {
			$newStarUserId = self::validateUuid($newStarUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the starred user id
		$this->starUserId = $newStarUserId;
	}

	/**
	 * inserts this Star into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 */
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO star(starPropertyId, starUserId) VALUES(:starPropertyId,:starUserId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["starPropertyId" => $this->starPropertyId->getBytes(), "starUserId" => $this->starUserId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Star from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 */
	public function delete(\PDO $pdo): void {

		// create query template
		// NOTE: which query do we need? do we need both?
		$query = "DELETE FROM star WHERE starPropertyId = :starPropertyId AND starUserId = :starUserId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder in the template
		$parameters = ["starPropertyId" => $this->starPropertyId->getBytes(), "starUserId" => $this->starUserId->getBytes()];
		$statement->execute($parameters);
	}

	/**********************************************
	 *    GetFooByBars - getStarByPropertyId    *
	 **********************************************/

	/**
	 * gets the Star by Property Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $starPropertyId property id to search for
	 * @return \SplFixedArray SplFixedArray of Stars found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 */
	public static function getStarByStarPropertyId(\PDO $pdo, $starPropertyId): \SplFixedArray {
		// sanitize the property id before searching
		try {
			$starPropertyId = self::validateUuid($starPropertyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT starPropertyId, starUserId FROM star WHERE starPropertyId = :starPropertyId";
		$statement = $pdo->prepare($query);

		// bind the star property id to the placeholder in the template
		$parameters = ["starPropertyId" => $starPropertyId->getBytes()];
		$statement->execute($parameters);

		// build an array of stars
		$stars = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$star = new Star($row["starPropertyId"], $row["starUserId"]);
				$stars[$stars->key()] = $star;
				$stars->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($stars);

	}
	/********************************************
	 *     GetFooByBars - getStarByUserId     *
	 ********************************************/

	/**
	 * gets the Star by user id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $starUserId star user id to search for
	 * @return \SplFixedArray array of Stars found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * \    */
	public static function getStarByUserId(\PDO $pdo, $starUserId): \SplFixedArray {
		// sanitize the user id before searching
		try {
			$starUserId = self::validateUuid($starUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT starPropertyId, starUserId FROM star WHERE starUserId = :starUserId";
		$statement = $pdo->prepare($query);

		// bind the star user id to the placeholder in the template
		$parameters = ["starUserId" => $starUserId->getBytes()];
		$statement->execute($parameters);

		// build an array of stars
		$stars = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$star = new Star($row["starPropertyId"], $row["starUserId"]);
				$stars[$stars->key()] = $star;
				$stars->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($stars);
	}

	/***********************************************************
	 *     GetFooByBars - getStarByPropertyIdAndUserId    *
	 ***********************************************************/

	/**
	 * gets the Star by property id and user id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $starPropertyId property id to search for
	 * @param Uuid|string $starUserId user id to search for
	 * @return Star|null Star found or null if not found
	 */
	public static function getStarByStarPropertyIdAndStarUserId(\PDO $pdo, $starPropertyId, $starUserId): ?Star {

		try {
			$starPropertyId = self::validateUuid($starPropertyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$starUserId = self::validateUuid($starUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT starPropertyId, starUserId FROM star WHERE starPropertyId = :starPropertyId AND starUserId = :starUserId";
		$statement = $pdo->prepare($query);

		// bind the property id and user id to the placeholder in the template
		$parameters = ["starPropertyId" => $starPropertyId->getBytes(), "starUserId" => $starUserId->getBytes()];
		$statement->execute($parameters);

		// grab the star from mySQL
		try {
			$star = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$star = new Star($row["starPropertyId"], $row["starUserId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($star);
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["starPropertyId"] = $this->starPropertyId->toString();
		$fields["starUserId"] = $this->starUserId->toString();
		return ($fields);
	}
}