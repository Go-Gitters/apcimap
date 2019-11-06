<?php
namespace GoGitters\ApciMap\Test;
use GoGitters\ApciMap\User;
use Lindsey Atencio\ApciMap\{User};
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/Classes/ValidateUuid.php");
/**
 * Full PHPUnit test for the User class
 *
 * This is a complete PHPUnit test of the User class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see User
 * @author Lindsey Atencio
 **/
class UserTest extends ApciMapTest {
	/**
	 * placeholder until User account is set up
	 */
	protected $VALID_ACTIVATION;
	/**
	 * valid userId to use
	 * @var string $VALID_USERID
	 **/
	protected $VALID_USERID = "@phpunit";
	/**
	 * second valid at handle to use
	 * @var string $VALID_ATHANDLE2
	 **/
	protected $VALID_USERID2 = "@passingtests";
	/**
	 * second valid USERID to use
	 * @var string $VALID_ATHANDLE2
	 **/
	protected $VALID_PROFILE_AVATAR_URL = "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif";
	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@phpunit.de";
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;
	/**
	 * valid phone number to use
	 * @var string $VALID_PHONE
	 **/
	protected $VALID_PHONE = "+12125551212";
}
