<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
	global $connection;
	if (!isset($_SESSION["user_id"])) {
		$_SESSION["message"] .= "Please log in before following a game";
	} else {
		// Inserts into relational table. This identifies which games the user is currently following.	
		// Once again, game is the only table that uses the syntax game_id.
		$user_id = mysql_prep($_SESSION["user_id"]);
		$game_id = mysql_prep($_GET["game_id"]);
		$game = find_game_by_id($game_id);
		
		$query  = "INSERT INTO currently_following ("; 
		$query .= " user_id, game_id ";
		$query .= ") VALUES (";
		$query .= " {$user_id}, {$game_id} ";
		$query .= ")";
		$result = mysqli_query($connection, $query); 
		//$result will not be a typical variable. It will be a resource.

		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Successs
			$safe_title = htmlspecialchars($game["title"]);
			$_SESSION["message"] .= "You are now following {$safe_title}.";
		} else {
			//Failure
			$_SESSION["message"] .= "Game Follow failed. Something went wrong. ";	
	  }
		redirect_to("index.php");
	}
?>