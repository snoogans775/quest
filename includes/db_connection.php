<?php
define("DB_SERVER", "localhost");
//define("DB_USER", "");
//define("DB_PASS", "");
//define("DB_NAME", "");
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
