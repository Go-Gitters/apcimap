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
 *
 */

class Star implements \JsonSerializable {
	use ValidateUuid;

			/*
			 * Star Property UUID; this is the foreign key
			 * @var Uuid $starPropertyUuid
			 */
			private $starPropertyUuid;

			/*
			 * Star User UUID for this Start; this is the foreign key
			 * @var Uuid $starUserUuid
			 */
			private $starUserUuid;

			/********************************************
			 * Constructor                              *
			 ********************************************/
			/*
			 * constructor for this Star
			 *
			 * @param string|Uuid $newStarPropertyUuid new star id or null if new
			 * @param string|Uuid $newStarUserUuid new star id or null if new
			 * @throws \InvalidArgumentException if data types are not valid
			 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
			 * @throws \TypeError if a data type violate type hints
			 * @throws \Exception if some other exception occurs
			 * @documentation https://php.net/manual/en/language.oop5.decon.php
			 */
			public function __construct($newStarPropertyUuid, $newStarUserUuid) {
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
			 /*
			 * accessor method for starPropertyUuid
			 *
			 * @return Uuid value of starPropertyUuid
			 */
			public function getStarPropertyUuid(): Uuid {
				return ($this->starPropertyUuid);
			}

			/*
			 * mutator method for starPropertyUuid
			 *
			 * @param Uuid| string $newStarPropertyUuid new value of starred property uuid
			 * @throws \RangeException if $newStarPropertyUuid is not positive
			 * @throws \TypeError if $newStarPropertyUuid is not a uuid or string
			 */
			public function setStarPropertyUuid( $newStarPropertyUuid): void {
				try {
					$uuid = self::validateUuid($newStarPropertyUuid);
				} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					$exceptionType = get_class($exception);
					throw(new $exceptionType($exception->getMessage(), 0, $exception));
				}

				// convert and store the starred property uuid
				$this->starPropertyUuid = $uuid;
			}

			/*
			 * accessor method for starUserUuid
			 *
			 * @return Uuid value of starUserUuid
			 */
			public function getStarUserUuid(): Uuid {
				return ($this->starUserUuid);
			}

			/*
			 * mutator method for starUserUuid
			 *
			 * @param Uuid| string $newStarUserUuid new value of starred user UUID
			 * @throws \RangeException if $newStarUserUuid is not positive
			 * @throws \TypeError if $newStarUserUuid is not a uuid or string
			 */
			public function setStarUserUuid( $newStarUserUuid): void {
				try {
					$uuid = self::validateUuid($newStarUserUuid);
				} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					$exceptionType = get_class($exception);
					throw(new $exceptionType($exception->getMessage(), 0, $exception));
				}

				// convert and store the starred user uuid
				$this->starUserUuid = $uuid;
	}

			/*
			 * inserts this Star into mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError if $pdo is not a PDO connection object
			 */
			public function insert(\PDO $pdo) : void {

				// create query template
				$query = "INSERT INTO star(starPropertyUuid, starUserUuid) VALUE(:starPropertyUuid,:starUserUuid)";
				$statement = $pdo->prepare($query);

				// bind the member variables to the placeholders in the template
				$parameters = ["starPropertyUuid" => $this->starPropertyUuid->getBytes(), "starUserUuid" => $this->starUserUuid->getBytes()];
				$statement->execute($parameters);
			}

			/*
			 * deletes this Star from mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError if $pdo is not a PDO connection object
			 */
			public function delete(\PDO $pdo) : void {

				// create query template
				// NOTE: which query do we need? do we need both?
				$query = "DELETE FROM star WHERE starPropertyUuid = :starPropertyUuid";
				$query = "DELETE FROM star WHERE starUserUuid = :starUserUuid";
				$statement = $pdo->prepare($query);

				// bind the member variables to the placeholder in the template
				// NOTE: which parameter do we need? both?
				$parameters = ["starPropertyUuid" => $this->starPropertyUuid->getBytes()];
				$parameters = ["starUserUuid" => $this->starUserUuid->getBytes()];
				$statement->execute($parameters);
			}

			/*
			 * updates this Star in mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError if $pdo is not a PDO connection object
			 */
			public function update(\PDO $pdo) : void {

				// create query template
				// NOTE: don't think below is correct
				$query = "UPDATE star SET starUserUuid = :starUserUuid WHERE starPropertyUuid = :starPropertyUuid";

				$parameters = ["starPropertyUuid" => $this->starPropertyUuid->getBytes(), "starUserUuid" => $this->starUserUuid->getBytes()];
				$statement->execute($parameters);
			}

			/**********************************************
			 * TODO GetFooByBars - getStarByPropertyUuid  *
			 **********************************************/

			/*
			 * gets the Star by Property Uuid
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param Uuid|string $starPropertyUuid star property uuid to search for
			 * @return \SplFixedArray SplFixedArray of Stars found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when a variable are not the correct data type
			 */
			public static function getStarByPropertyUuid(\PDO $pdo, $starPropertyUuid) : \SplFixedArray {
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
				$star = new \SplFixedArray($statement->rowCount());
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				while(($row = $statement->fetch()) !== false) {
					try {
						$star = new Star($row["starPropertyUuid"], $row["starUserUuid"]);
						$star[$star->key()] = $star;
						$star->next();
					} catch(\Exception $exception) {
						// if the row couldn't be converted, rethrow it
						throw(new \PDOException($exception->getMessage(), 0, $exception));
					}
				}
				return($star);

			}
			/********************************************
			 * TODO GetFooByBars - getStarByUserUuid    *
			 ********************************************/

	/*
	 * gets the Star by User Uuid
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $starUserUuid star user uuid to search for
	 * @return \SplFixedArray SplFixedArray of Stars found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 */
	public static function getStarByUserUuid(\PDO $pdo, $starUserUuid) : \SplFixedArray {
		// sanitize the property uuid before searching
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
		$star = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$star = new Star($row["starPropertyUuid"], $row["starUserUuid"]);
				$star[$star->key()] = $star;
				$star->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($star);

	}

			/***********************************************************
			 * TODO GetFooByBars - getStarByPropertyUuidAndUserUuid    *
			 ***********************************************************/

	/*
	 * gets the Star by Property Uuid
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $starPropertyUuid star property uuid to search for
	 * @return \SplFixedArray SplFixedArray of Stars found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 */
	public static function getStarByPropertyUuid(\PDO $pdo, $starPropertyUuid) : \SplFixedArray {
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
		$star = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$star = new Star($row["starPropertyUuid"], $row["starUserUuid"]);
				$star[$star->key()] = $star;
				$star->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($star);

	}



	//Closing bracket for Class!!!!!!!!!!!!!!!!!!!
}