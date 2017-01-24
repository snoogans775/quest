<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 
if (isset($_POST["submit"])) {
	global $connection;
	$safe_user_id = mysql_prep($_POST["user_id"]);
	$safe_game_id = mysql_prep($_POST["game_id"]);
	
	$query  = "DELETE ";
	$query .= "FROM currently_following ";
	$query .= "WHERE user_id = {$safe_user_id} " ;
	$query .= "AND game_id = {$safe_game_id} ";
	$query .= "LIMIT 1 ";
	$result = mysqli_query($connection, $query);
	confirm_query($result);
	
	if ($result && mysqli_affected_rows($connection) > 0) {
		//Successs
		$game = find_game_by_id($safe_game_id);
		$_SESSION["message"] .= "You are no longer following {$game["title"]}.";
		redirect_to("manage_user.php");
	} else {
		//Failure
		$_SESSION["message"] .= "Operation failed. Please contact the webmaster for help.";
		redirect_to("manage_user.php");
	} 
}	
?>