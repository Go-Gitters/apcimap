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

			/********************************************
			 * Declare and document all state variables *
			 ********************************************/

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

			/**
			 * constructor for this Star
			 *
			 * @param string|Uuid $newStarPropertyUuid new star id or null if new
			 * @param string|Uuid $newStarUserUuid new star id or null if new
			 * @throws \InvalidArgumentException if data types are not valid
			 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
			 * @throws \TypeError if a data type violate type hints
			 * @throws \Exception if some other exception occurs
			 * @documentation https://php.net/manual/en/language.oop5.decon.php
			 **/
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


		class Star {
			//TODO write and document all state variables
			/********************************************
			 * Declare and document all state variables *
			 ********************************************/
			/*
			 * TODO $propertyUuid
			 */
			/*
			 * TODO $propertyCity
			 */
			/*
			 * TODO $propertyLatitude
			 */
			/*
			 * TODO $propertyLongitude
			 */
			/*
			 * TODO $propertyStreetAddress
			 */
			/*
			 * TODO $propertyValue
			 */
			/********************************************
			 * TODO Constructor method                  *
			 ********************************************/
			/********************************************
			 * TODO Getters and Setters                 *
			 ********************************************/
			/*
			 * TODO $propertyUuid
			 */
			/*
			 * TODO $propertyCity
			 */
			/*
			 * TODO $propertyLatitude
			 */
			/*
			 * TODO $propertyLongitude
			 */
			/*
			 * TODO $propertyStreetAddress
			 */
			/*
			 * TODO $propertyValue
			 */
			/********************************************
			 * TODO GetFooByBars                        *
			 ********************************************/
//Closing bracket for Class!!!!!!!!!!!!!!!!!!!
}