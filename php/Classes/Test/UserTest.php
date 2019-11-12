<?php
namespace GoGitters\ApciMap\Test;
use Ramsey\Uuid\Uuid;
use GoGitters\ApciMap\{User};
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/ValidateUuid.php");
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
	 * Valid user profile
	 * @var User user
	 */
	protected $user = null;
	/**
	 * @var Uuid  $VALID_USERID
	 */
	protected $VALID_ID ="";
	/** @var string activation token */
	protected $VALID_ACTIVATION = "ALP127CTINP3L4G8AINTN8A2N8FO3NRI";
	/**
	 * valid user email
	 * @var string $VALID_USEREMAIL
	 */
	protected $VALID_EMAIL = "lba@cnm.edu";
/**
 * valid user hash for user account
 * @var string $VALID_USERHASH
 */
	protected $VALID_HASH = "d4k6fiofjiaomfrc98tmcjfiwoam894pwu4983mcftja8r943mjf4mjr483qmrcjp9mjfcx8943qh459frjeoifnmcwaonfje";
	/**
	 * valid username for user account
	 * @var string $VALID_USERNAME
	 */
	protected $VALID_USERNAME = "linaten";

	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp() : void {
		parent::setUp();
		//
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid user and verify that the actual mySQL data matches
	 **/
	public function testInsertValidUser() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$user->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUser($this->getPDO(), $user->getUser());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserUsername(), $this->VALID_USERNAME);
	}
	/**
	 * test inserting a User, editing it, and then updating it
	 **/
	public function testUpdateValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		// create a new User and insert to into mySQL
		$user = generateUuidV4();
		$user = new user ($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$user->insert($this->getPDO());
		$user->insert($this->getPDO());
		// edit the user and update it in mySQL
		$user->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $UserId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserUsername(), $this->VALID_USERNAME);
	}

	/**
	 * test creating a User and then deleting it
	 **/
	public function testDeleteValidUser() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$user->insert($this->getPDO());
		// delete the User from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$user->delete($this->getPDO());
		// grab the data from mySQL and enforce the user does not exist/
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$this->assertNull($pdoUser);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("user"));
	}
	/**
	 * test grabbing a user by its activation token
	 */
	public function testGetValidUserByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		$userId = generateUuidV4();
		$user = new User ($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$user->insert($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
$pdoUser = User::getUserByUserActivationToken($this->getPDO(), $user->getUserActivationToken());
$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
$this->assertEquals($pdoUser->getUserId(), $userId);
$this->assertEquals($pdoUser->getActivationToken(), $this->VALID_ACTIVATION);
$this->assertEquals($pdoUser->getEmail(), $this->VALID_EMAIL);
$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
$this->assertEquals($pdoUser->getUserUsername(), $this->VALID_USERNAME);
}
	/**
	 *
	 * test grabbing a User by an email that does not exists
	 **/
	public function testGetInvalidUserActivation() : void {
		// grab an email that does not exist
		$user = User::getUserByUserActivationToken($this->getPDO(), "6675636b646f6e616c646472756d7066");
		$this->assertNull($user);
	}
		/**
		 * test grabbing a User by email
		 **/
		public function testGetValidUserByEmail() : void {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("user");
			$userId = generateUuidV4();
			$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$user->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$userId = User::getUserByUserEmail($this->getPDO(), $user->getUserEmail());
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_USEREMAIL);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->get(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserUsername(), $this->VALID_USERNAME);
	}
		/**
		 * test grabbing a User by an email that does not exists
		 **/
		public function testGetInvalidUserByEmail() : void {
			// grab an email that does not exist
			$user = User::getUserByUserEmail($this->getPDO(), "does@not.exist");
			$this->assertNull($user);
		}

		/**
		 * test grabbing a User by username
		 **/
		public function testGetValidUserByUsername() : void {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("user");
			$userId = generateUuidV4();
			$user = new User($userId,$this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$user->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$userId = User::getUserByUserEmail($this->getPDO(), $user->getUserEmail());
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserUsername(), $this->VALID_USERNAME);
	}
		/**
		 * test grabbing a User by an email that does not exists
		 **/
		public function testGetInvalidUserByUsername() : void {
			// grab a username that does not exist
			$user = User::getUserByUserUsername($this->getPDO(), "does@not.exist");
			$this->assertNull($user);
		}
	}