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



	// grab the data from mySQL and enforce the fields match our expectations
$pdoUser = User::getUserByUserActivationToken($this->getPDO(), $user->getUserActivationToken());
$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
$this->assertEquals($pdoUser->getUserId(), $userId);
$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
$this->assertEquals($pdoUser->get(), $this->VALID_EMAIL);
$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PHONE);
}
	/**
	 * test grabbing a Profile by an email that does not exists
	 **/
	public function testGetInvalidProfileActivation() : void {
	// grab an email that does not exist
	$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "6675636b646f6e616c646472756d7066");
	$this->assertNull($profile);