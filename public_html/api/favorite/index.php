<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// id may be equal to favorite from Favorite class at the bottom of the program
use {
	Favorite
};

/**
 * api for the Favorite class
 *
 * @author Luc Flynn
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection

	$pdo = connectToEcryptedMySQL('/etc/apache2/capstone-mysql/ddctwitter.ini');
	//// mock a logged in user by mocking the session and assigning a specific user to it.
	// this is only for testing purposes and should not be in the live code.
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);

	//determine which http method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input

	$id = filter_input(INPUT_GET, "Id", FILTER_VALIDATE_INT);
	$faveProductid = filter_input(INPUT_GET, "faveProductId", FILTER_VALIDATE_INT);
	$faveProductProfileid = filter_input(INPUT_GET, "faveProductProfileId", FILTER_VALIDATE_INT);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that tweet is returned, otherwise all tweets are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific tweet or all tweets and update reply
			if(empty($id) === false) {
			$favorite = Favorite::getfavesByfaveId($pdo, $id);
			if($favorite !== null) {
				$reply->data = $favorite;
				}
		} else if(empty($faveProdctid) === false) {
					$favore = Favorite::getfavesByfaveId($pdo, $faveProductid)->toArray();
					if($favorite !== null) {
						$reply->data = $favorite;
				}
			}
		} else if(empty($faveProdctProfileid) === false) {
		$favorite = Favorite::getfavesByfaveId($pdo, $faveProductProfileId)->toArray();
		if($favorite !== null) {
			$reply->data = $favorite;
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end send, and stores it in $request content. here we are using file_get_conentes... to get the request from the front end.
		$requestObject = json_decode($requestContent);
		// This line then decodes the JSOn package and stores that result in $requestObject

		//make sure the fave content is availbe
		if(empty($requestObject->faveProductProfileId) === true) {
					throw
		}





}
	 
}