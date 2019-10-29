<?php

namespace LisaLeeNM\apcimap;
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * Star Class
 *
 * This class includes data for starPropertyUuid and starUserUuid.
 *
 * @author Lisa Lee <llee28@cnm.edu>
 * @version 0.0.1
 **/
class Star implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * Star Property UUID for this Star; this is the foreign key
	 * @var Uuid $starPropertyUuid
	 **/
	private $starPropertyUuid;

	/**
	 * Star User UUID for this Start; this is the foreign key
	 * @var Uuid $starUserUuid
	 **/
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

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid| string $newAuthorId new value of author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if $newAuthorId is not a uuid or string
	 **/
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->authorId = $uuid;
	}
