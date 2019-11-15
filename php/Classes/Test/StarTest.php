<?php


namespace GoGitters\ApciMap\Test;

//grab the Property Class
use GoGitters\ApciMap\{Property, User, Star};
use Ramsey\Uuid\Uuid;

require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Class StarTest
 *
 * A complete PHPUnit test of the Star class.  It is complete because *ALL* mySQL/PDO enabled methods are tested for
 * both valid and invalid inputs
 *
 * @see Property
 * @package GoGitters\ApciMap\Test
 *
 * @author Lisa Lee
 */


class StarTest extends ApciMapTest {

	/**
	 * User that starred the Property; this is for foreign key relations
	 * @var User $user
	 **/
	protected $user;

	/**
	 * Property that was starred; this is for foreign key relations
	 * @var Property $property
	 **/
	protected $property;

	/**
	 * valid user hash to use
	 * @var $VALID_USERHASH
	 **/
	protected $VALID_USERHASH;

	/**
	 * valid user activationToken to create the user object to own the test
	 * @var string $VALID_USERACTIVATIONTOKEN
	 **/
	protected $VALID_USERACTIVATIONTOKEN;
}


