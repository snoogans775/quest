<?php
define("DB_SERVER", "localhost");
define("DB_USER", "snoogans775");
define("DB_PASS", "+Pe5Qr6%unC-i");
define("DB_NAME", "quest");
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
