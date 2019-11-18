<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use GoGitters\ApciMap\User;
/**
 * API to check user activation status
 * @author Lisa Lee
 **/
// check the session; if it is not active, start the session
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try{
	// grab the MySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/map.ini");
	$pdo = $secrets->getPdoObject();

	// check the HTTP method being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


}