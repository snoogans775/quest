<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

define("DB_SERVER", $_ENV['DEVSERVER']);
define("DB_USER", $_ENV['DBUSER']);
define("DB_PASS", $_ENV['PASSWORD']);
define("DB_NAME", $_ENV['DBNAME']);
	//creates a database connection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	// tests connection for errors
	if(mysqli_connect_errno()) {
		die("Database connection failed: ".
					mysqli_connect_error() .
					" (" . mysqli_connect_errno() . ")"
		);
	}
	
?>
