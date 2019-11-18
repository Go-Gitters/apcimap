<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use GoGitters\ApciMap\{User, Property, Crime, Star};

/**
 * api for Crime class
 *
 * @author Lisa Lee
 **/
// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
	$pdo = $secrets->getPdoObject();

	// determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$lat = filter_input(INPUT_GET, "lat", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$long = filter_input(INPUT_GET, "long", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$distance = filter_input(INPUT_GET, "distance", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// make sure the id is valid for methods that require it
if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
	throw(new InvalidArgumentException("id cannot be empty or negative", 402));
}

	// handle GET request - if id is present, that crime incident report is returned, otherwise all crime incident reports are returned
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		// get a specific crime incident report or all crime incident reports and update reply
		if(empty($id) === false) {
			$reply->data = Crime::getCrimeByCrimeId($pdo, $id);

		// get crime incident report by distance if there is a lat, long & distance
		} else if((empty($lat) === false) && (empty($long === false) && (empty($distance === false)) {
			$reply->data = Crime::getCrimeByDistance($pdo, $lat, $long, $distance)->toArray();