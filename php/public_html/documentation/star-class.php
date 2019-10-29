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

