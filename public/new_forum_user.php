<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
			
		define("DB_SERVER", "localhost");
		define("DB_USER", "rvgsym5_admin");
		define("DB_PASS", "Koj1is#1");
		define("DB_NAME", "rvgsym5_forum");
		//creates a database connection
		$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		// tests connection for errors
		if(mysqli_connect_errno()) {
			die("Database connection failed: ". 
				mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
		}

		$username = mysqli_real_escape_string($connection, $_GET["user"]);
		$password = mysqli_real_escape_string($connection, $_GET["pass"]);
		$hashed_password = sha1(strtolower($username) . $password);

		//performs database query
		$query  = "INSERT INTO smf_members ("; 
		$query .= "member_name, real_name, passwd";
		$query .= ") VALUES (";
		$query .= "'{$username}', '{$username}', '{$hashed_password}'";
		$query .= ")";
		$result = mysqli_query($connection, $query); 
		//$result will not be a variable. It will be a resource.

		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Success
			$_SESSION["message"] .= " And forum account created!";
			redirect_to("new_user.php");
		} else {
			//Failure
			$_SESSION["message"] .= " Forum registration failed.". DB_SERVER. DB_USER.DB_PASS. DB_NAME;
			redirect_to("new_user.php");
		}
echo $_SESSSION["message"];
?>