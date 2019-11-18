<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use UssHopper\DataDesign\{Like, Profile, Tweet};
use GoGitters\ApciMap\{Property};

/**
 * api for the Property Class
 *
 *
 * @author Kyla Bendt <kylabendt@gmail.com>
 *
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$lat = filter_input(INPUT_GET, "lat", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$long = filter_input(INPUT_GET, "long", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$distance = filter_input(INPUT_GET, "distance", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}


	// handle GET request - if id is present, that property is returned,
	// if lat long & distance are present, properties within that are area returned
	//if nothing is present, all properties are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific property if there is an id
		if(empty($id) === false) {
			$reply->data = Property::getPropertyByPropertyId($pdo, $id);
			//get property by distance if there is a lat, long & distance
		} else if((empty($lat) === false) && (empty($long) === false) && (empty($distance) === false)){
			$reply->data = Property::getPropertyByDistance($pdo, $lat, $long, $distance)->toArray();;
			//otherwise return all properties
		} else {
			$properties = Property::getAllProperties($pdo)->toArray();
			//TODO: edit starting here!
			$tweetProfiles = [];
			foreach($tweets as $tweet){
				$profile = 	Profile::getProfileByProfileId($pdo, $tweet->getTweetProfileId());
				$tweetProfiles[] = (object)[
					"tweetId"=>$tweet->getTweetId(),
					"tweetProfileId"=>$tweet->getTweetProfileId(),
					"tweetContent"=>$tweet->getTweetContent(),
					"tweetDate"=>$tweet->getTweetDate()->format("U.u") * 1000,
					"profileAtHandle"=>$profile->getProfileAtHandle(),
					"profileAvatarUrl"=>$profile->getProfileAvatarUrl(),
				];
			}
			$reply->data = $tweetProfiles;
		}
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();
		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post tweets", 401));
		}
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure tweet content is available (required field)
		if(empty($requestObject->tweetContent) === true) {
			throw(new \InvalidArgumentException ("No content for Tweet.", 405));
		}
		// make sure tweet date is accurate (optional field)
		if(empty($requestObject->tweetDate) === true) {
			$requestObject->tweetDate = null;
		}
		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the tweet to update
			$tweet = Tweet::getTweetByTweetId($pdo, $id);
			if($tweet === null) {
				throw(new RuntimeException("Tweet does not exist", 404));
			}
			//enforce the end user has a JWT token
			//enforce the user is signed in and only trying to edit their own tweet
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $tweet->getTweetProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this tweet", 403));
			}
			validateJwtHeader();
			// update all attributes
			//$tweet->setTweetDate($requestObject->tweetDate);
			$tweet->setTweetContent($requestObject->tweetContent);
			$tweet->update($pdo);
			// update reply
			$reply->message = "Tweet updated OK";
		} else if($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post tweets", 403));
			}
			//enforce the end user has a JWT token
			validateJwtHeader();
			// create new tweet and insert into the database
			$tweet = new Tweet(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->tweetContent, null);
			$tweet->insert($pdo);
			// update reply
			$reply->message = "Tweet created OK";
		}
	//Delete method
	} else if($method === "DELETE") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the Property to be deleted
		$property = Property::getPropertyByPropertyId($pdo, $id);
		if($property === null) {
			throw(new RuntimeException("Property does not exist", 404));
		}
		//this is where a test to control delete access for only admins would be- something like
//		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserEmail() !== "kylabendt@gmail.com" {
//			throw(new \InvalidArgumentException("You are not allowed to delete this property", 403));
//		}
		//enforce the end user has a JWT token
		validateJwtHeader();
		// delete tweet
		$property->delete($pdo);
		// update reply
		$reply->message = "Property deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 418));
	}

// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);