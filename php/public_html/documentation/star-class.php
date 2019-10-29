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
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * token handed out to verify that the profile is valid and not malicious
	 * @var string $authorActivationToken
	 **/
	private $authorActivationToken;
	/**
	 * avatar URL for this person
	 * @var string $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 * email for this person; this is a unique index
	 * @var string $profileEmail
	 **/
	private $authorEmail;
	/**
	 * hash for user password
	 * @var string $authorHash
	 **/
	private $authorHash;
	/**
	 * username for user
	 * @var string $authorUsername
	 **/
	private $authorUsername;

