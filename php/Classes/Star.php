<?php


namespace GoGitters\ApciMap;
require_once("autoload.php");

require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/*
 * Star Class
 *
 * This class includes data for starPropertyUuid and starUserUuid.
 *
 * @author Lisa Lee
 * @version 0.0.1
 */

class Star {
	use ValidateUuid;

			/**
			 * id of the Property being starred; this is a component of a composite primary key (and a foreign key)
			 * @var Uuid $starPropertyUuid
			 */
			private $starPropertyUuid;

			/**
			 * id of the User who starred; this is a component of a composite primary key (and a foreign key)
			 * @var Uuid $starUserUuid
			 */
			private $starUserUuid;

			/********************************************
			 * Constructor                              *
			 ********************************************/
			/**
			 * constructor for this Star
			 *
			 * @param string|Uuid $newStarPropertyUuid id of the parent Property
			 * @param string|Uuid $newStarUserUuid id of the parent User
\			 * @throws \InvalidArgumentException if data types are not valid
			 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
			 * @throws \TypeError if a data type violate type hints
			 * @throws \Exception if some other exception occurs
			 */
			public function __construct($newStarPropertyUuid, $newStarUserUuid) {
				// use the mutator methods to do the work for us
				try {
					$this->setStarPropertyUuid($newStarPropertyUuid);
					$this->setStarUserUuid($newStarUserUuid);
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
			 * accessor method for property uuid
			 *
			 * @return Uuid value of property uuid
			 */
			public function getStarPropertyUuid(): Uuid {
				return ($this->starPropertyUuid);
			}

			/**
			 * mutator method for Property Uuid
			 *
			 * @param string $newStarPropertyUuid new value of property uuid
			 * @throws \RangeException if $newStarPropertyUuid is not positive
			 * @throws \TypeError if $newStarPropertyUuid is not a uuid or string
			 */
			public function setStarPropertyUuid($newStarPropertyUuid): void {
				try {
					$newStarPropertyUuid = self::validateUuid($newStarPropertyUuid);
				} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					$exceptionType = get_class($exception);
					throw(new $exceptionType($exception->getMessage(), 0, $exception));
				}

				// convert and store the starred property uuid
				$this->starPropertyUuid = $newStarPropertyUuid;
			}

			/**
			 * accessor method for user uuid
			 *
			 * @return Uuid value of user uuid
			 */
			public function getStarUserUuid(): Uuid {
				return ($this->starUserUuid);
			}

			/**
			 * mutator method for user Uuid
			 *
			 * @param string $newStarUserUuid new value of user uuid
			 * @throws \RangeException if $newStarUserUuid is not positive
			 * @throws \TypeError if $newStarUserUuid is not a uuid or string
			 */
			public function setStarUserUuid($newStarUserUuid): void {
				try {
					$newStarUserUuid = self::validateUuid($newStarUserUuid);
				} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					$exceptionType = get_class($exception);
					throw(new $exceptionType($exception->getMessage(), 0, $exception));
				}

				// convert and store the starred user uuid
				$this->starUserUuid = $newStarUserUuid;
	}

			/**
			 * inserts this Star into mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors occur
			 */
			public function insert(\PDO $pdo) : void {

				// create query template
				$query = "INSERT INTO star(starPropertyUuid, starUserUuid) VALUES(:starPropertyUuid,:starUserUuid)";
				$statement = $pdo->prepare($query);

				// bind the member variables to the placeholders in the template
				$parameters = ["starPropertyUuid" => $this->starPropertyUuid->getBytes(), "starUserUuid" => $this->starUserUuid->getBytes()];
				$statement->execute($parameters);
			}

			/**
			 * deletes this Star from mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors occur
			 */
			public function delete(\PDO $pdo) : void {

				// create query template
				// NOTE: which query do we need? do we need both?
				$query = "DELETE FROM star WHERE starPropertyUuid = :starPropertyUuid AND starUserUuid = :starUserUuid";
				$statement = $pdo->prepare($query);

				// bind the member variables to the placeholder in the template
				$parameters = ["starPropertyUuid" => $this->starPropertyUuid->getBytes(), "starUserUuid" => $this->starUserUuid->getBytes()];
				$statement->execute($parameters);
			}

			/**********************************************
			 *     GetFooByBars - getStarByPropertyUuid    *
			 **********************************************/

			/**
			 * gets the Star by Property Uuid
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param Uuid|string $starPropertyUuid property uuid to search for
			 * @return \SplFixedArray SplFixedArray of Stars found or null if not found
			 * @throws \PDOException when mySQL related errors occur
			 */
			public static function getStarByStarPropertyUuid(\PDO $pdo, $starPropertyUuid) : \SplFixedArray {
				// sanitize the property uuid before searching
				try {
					$starPropertyUuid = self::validateUuid($starPropertyUuid);
				} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}

				// create query template
				$query = "SELECT starPropertyUuid, starUserUuid FROM star WHERE starPropertyUuid = :starPropertyUuid";
				$statement = $pdo->prepare($query);

				// bind the star property uuid to the placeholder in the template
				$parameters = ["starPropertyUuid" => $starPropertyUuid->getBytes()];
				$statement->execute($parameters);

				// build an array of stars
				$stars = new \SplFixedArray($statement->rowCount());
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				while(($row = $statement->fetch()) !== false) {
					try {
						$star = new Star($row["starPropertyUuid"], $row["starUserUuid"]);
						$stars[$stars->key()] = $star;
						$stars->next();
					} catch(\Exception $exception) {
						// if the row couldn't be converted, rethrow it
						throw(new \PDOException($exception->getMessage(), 0, $exception));
					}
				}
				return($stars);

			}
			/********************************************
			 *     GetFooByBars - getStarByUserUuid     *
			 ********************************************/

	/**
	 * gets the Star by user Uuid
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $starUserUuid star user uuid to search for
	 * @return \SplFixedArray array of Stars found or null if not found
	 * @throws \PDOException when mySQL related errors occur
\	 */
	public static function getStarByUserUuid(\PDO $pdo, $starUserUuid) : \SplFixedArray {
		// sanitize the user uuid before searching
		try {
			$starUserUuid = self::validateUuid($starUserUuid);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT starPropertyUuid, starUserUuid FROM star WHERE starUserUuid = :starUserUuid";
		$statement = $pdo->prepare($query);

		// bind the star user uuid to the placeholder in the template
		$parameters = ["starUserUuid" => $starUserUuid->getBytes()];
		$statement->execute($parameters);

		// build an array of stars
		$stars = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$star = new Star($row["starPropertyUuid"], $row["starUserUuid"]);
				$stars[$stars->key()] = $star;
				$stars->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($stars);
	}

			/***********************************************************
			 *     GetFooByBars - getStarByPropertyUuidAndUserUuid    *
			 ***********************************************************/

	/**
	 * gets the Star by property Uuid and user Uuid
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $starPropertyUuid property uuid to search for
	 * @param Uuid|string $starUserUuid user uuid to search for
	 * @return Star|null Star found or null if not found
	 */
	public static function getStarByStarPropertyUuidAndStarUserUuid(\PDO $pdo, $starPropertyUuid, $starUserUuid) : ?Star {

		try {
			$starPropertyUuid = self::validateUuid($starPropertyUuid);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$starUserUuid = self::validateUuid($starUserUuid);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT starPropertyUuid, starUserUuid FROM star WHERE starPropertyUuid = :starPropertyUuid AND starUserUuid = :starUserUuid";
		$statement = $pdo->prepare($query);

		// bind the property uuid and user uuid to the placeholder in the template
		$parameters = ["starPropertyUuid" => $starPropertyUuid->getBytes(), "starUserUuid" => $starUserUuid->getBytes()];
		$statement->execute($parameters);

		// grab the star from mySQL
		try {
			$star = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$star = new Star($row["starPropertyUuid"], $row["starUserUuid"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($star);
	}

	//Closing bracket for Class!!!!!!!!!!!!!!!!!!!
}