<?php include("../includes/mng_usr_header.php"); ?>
	
<?php
if (isset($_POST["submit"])) {
	//validations
	$required_fields = array("comments");
	validate_presences($required_fields);
	
	if (empty($errors)) {
		global $connection;
		$comments = mysql_prep($_POST["comments"]);
		$links = mysql_prep($_POST["links"]);
		$user_id = mysql_prep($_POST["user_id"]);
		$source_user_id = mysql_prep($_POST["source_user_id"]);
		
		$query  = "INSERT INTO completion_commits "; 
		$query .= "(user_id, source_user_id, comments, links";
		$query .= ") VALUES (";
		$query .= "{$user_id}, {$source_user_id}, '{$comments}', '{$links}' ";
		$query .= ") ";	
		// $query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		
		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Successs
			/* Deprecated until mailing libraries are installed
			
			$source_user = find_user_by_id($source_user_id);
			$subject = "A Quester needs your help!";
			$message = "Oh Frabjous day! Calloh! Callay! \r\n \r\n
				A Quester has completed a game from your list! \r\n
				 They need you to confirm their exploits so that they may earn the 
				 points they deserve. \r\n
				 Please log in to your account at rvgsymphony.com/quest to confirm this act of 
				 bravery and courage.";
			mail($source_user["email"], $subject, $message);
			*/
			$_SESSION["message"] .= "Your completion has been recorded. We will send a confirmation to your email address when the Quester receives your comments.";
			redirect_to("commit_game.php");
		} else {
			//Failure
			$_SESSION["message"] .= "Confirmation failed. Please contact the webmaster for help.";
			redirect_to("commite_game.php");
		}
	}
}
?>

<!-- BEGIN PAGE CONTENT -->
	<h1>Commit Game Completion</h1>
	<img align="left" src="images/construction.jpg"></img>UNDER CONSTRUCTION!
	<p>The game completion mechanic is still in development. If you can not contact the Quester that listed the game you have completed, please contact a moderator in the <a href="http://www.rvgsymphony.com/quest/forum/index.php?board=12">Forums</a> and we will record your completion.</p>
	<br />
	<?php
	if ($_GET["user_id"] && $_GET["game_id"]) {
		$list_item = find_list_item($_GET["user_id"], $_GET["game_id"]);
		$game = find_game_by_id($_GET["game_id"]);
		$current_user = find_user_by_id($_SESSION["user_id"]);
		$source_user =  find_user_by_id($list_item["user_id"]);
		if (empty($source_user["email"])) {
			echo "{$source_user["username"]} has not provided an email address. <br />";
			echo "Please send them a message through the <a href=\"../forum/index.php?action=search\">FORUMS</a>.<br />";
		} elseif (empty($current_user["email"])) {
			echo "You have not provided an email. Please update your <a href=\"user_info.php\">Email Settings</a> to complete a game.";
		} elseif (!empty($source_user["email"] && $current_user["email"])) { ?>
				Game: <?php echo $game["title"] ;?> &nbsp&nbsp 
				User: <?php echo $source_user["username"]; ?> <br />
				Challenge: 
				<?php
				if (!empty($list_item["challenge"])) { 
					echo $list_item["challenge"];
				} else {
					echo "Complete Game";
				}
			?>
			<br /> <br />
			<form action="commit_game.php" method="POST">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
				<input type="hidden" name="source_user_id" value="<?php echo $source_user["id"]; ?>">
				Comments <br />
				<input type="text" name="comments" /> <br />
				Links to related forum posts? <br />
				<input type="text" name"links" /> <br />
				<input type="submit" name="submit" value="Submit!" />			
			</form>
	<?php
		}
	}
	?>
<!-- END OF <div class="page"> FROM MNG_USR_HEADER.PHP -->
	<?php include("../includes/footer.php"); ?>
</div>