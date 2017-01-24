<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 

		global $connection;
		$safe_user_id = mysql_prep($_GET["u_id"]);
		$safe_source_user_id = mysql_prep($_GET["su_id"]);
		$safe_game_id = mysql_prep($_GET["g_id"]);	
		
		$conf_check = check_confirmation($safe_user_id, $safe_source_user_id, $safe_game_id);
		echo $conf_check;
		
		if ($conf_check == 0) {
			$query  = "UPDATE completion_commits ";
			$query .= "SET ";
			$query .= "confirmed = ";
			$query .= " 1 ";
			$query .= "WHERE user_id = {$safe_user_id} " ;
			$query .= "AND game_id = {$safe_game_id} ";
			$query .= "AND source_user_id = {$safe_source_user_id} ";
			$query .= "AND confirmed != 1 ";
			$result = mysqli_query($connection, $query);
			confirm_query($result);
		
			if ($result && mysqli_affected_rows($connection) >= 0) {
				//Successs
				$game = find_game_by_id($safe_game_id);
				$_SESSION["message"] .= "Thank you for confirming. {$game["title"]} has been completed from your list, and the user has received your confirmation.";
				add_points($safe_user_id, 400);
				add_points($safe_source_user_id, 100);
				$source_user = find_user_by_id($safe_source_user_id);
				$game = find_game_by_id($safe_game_id);
				send_email('Your Game Completion has been recorded!','Congrats on completing '. $game['title'], $source_user['email']);
				redirect_to("index.php");
			} else {
				//Failure
				$_SESSION["message"] .= "Game Confirmation failed. Contact the webmaster at quest@rvgsymphony.com for help";
				redirect_to("index.php");
			}
		} else {
			// if($conf_check == 1)
			// GAME HAS ALREADY BEEN CONFIRMED
			$_SESSION["message"] .= "Game has already been confirmed";
			redirect_to("index.php");
		}
?>