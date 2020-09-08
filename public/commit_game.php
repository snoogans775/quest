<?php include("../includes/mng_usr_header.php"); ?>
	
<?php
if (isset($_POST["submit"])) {
	
	
	if (empty($errors)) {
		global $connection;
		$comments = mysql_prep($_POST["comments"]);
		$user_id = mysql_prep($_POST["user_id"]);
		$source_user_id = mysql_prep($_POST["source_user_id"]);
		$game_id = mysql_prep($_POST["game_id"]);
		
		$query  = "INSERT INTO completion_commits SET 
							user_id = {$user_id}, 
		 					game_id = {$game_id},
							source_user_id = {$source_user_id},
							comments = '{$comments}'";
							
		// $query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		echo "<marquee>....Working.....</marquee>";
		confirm_query($result);
		
		//ENTER TAGS INTO games_tags
		if ($_POST["tags"]) {
			
			$query  = "INSERT INTO games_tags "; 
			$query .= "(game_id, tag_id) VALUES ";
			foreach ($_POST["tags"] as $tag_id) {
				$query .= "( ". $game_id. ", ". $tag_id. " ), ";
			}	
			$query = substr($query, 0, -2);
			echo $query;
			$result = mysqli_query($connection, $query);
			confirm_query($result);	

		}
		
		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Success
			
			$user = find_user_by_id($user_id);
			$source_user = find_user_by_id($source_user_id);
			$game = find_game_by_id($game_id);
			$tags = find_tags();
			
			// SENDS EMAIL TO SOURCE_USER
			$subject = "A Quester needs your help!";
			$body = "<h2>Oh Frabjous day! Callooh! Callay!</h2> \r\n \r\n
				 {$user["username"]} has completed {$game["title"]} from your list! <br /> \r\n
				 They need you to confirm their exploits so they may earn the 
				 points they deserve. <br /><br /> \r\n
				 
				 {$user["username"]} wanted to let you know: <br /> \r\n
				 <p>\"{$comments} \"</p> <br /> \r\n
				 And they tagged the game as: <br /> \r\n";
				 while ($db_tag = mysqli_fetch_assoc($tags)) {
					 if (in_array($db_tag["id"], $_POST["tags"])) {
						 $body .= "--  {$db_tag["name"]}  ";
					 }
				 }
				 $body .= "--<br /><br />";
				 $body .= "Please click the following link to confirm this act of bravery and courage. <br /><br />
				 <a href=\"http://www.rvgsymphony.com/quest/public/confirmation.php?u_id={$user_id}&su_id={$source_user_id}&g_id={$game_id}\" > http://www.rvgsymphony.com/quest/public/confirmation.php?u_id={$user_id}&su_id={$source_user_id}&g_id={$game_id} </a> \r\n \r\n <br /><br />";
			send_email($subject, $body, $source_user["email"]);
			$_SESSION["message"] .= "Your completion has been recorded.";
			redirect_to("commit_game.php");
		} else {
			//Failure
			$_SESSION["message"] .= "Confirmation failed. Please contact the webmaster for help.";
			redirect_to("commit_game.php");
		}
	}
}
?>

<!-- BEGIN PAGE CONTENT -->
<br />
<a href="manage_user.php">Your Quest ></a>
<a href="commit_game.php">Game Completion ></a>
<hr />
	<h1>Game Completion</h1>
		<div id="menu">
		<?php
	
		// CHECKS FOR $_GET VALUE AND THEN PULLS RESOURCES FROM DATABASE
		$current_user = find_user_by_id($_SESSION["user_id"]);
		if (empty($current_user["email"])) {
					echo "You have not provided an email. Please update your <a href=\"user_info.php\">Email Settings</a> to complete a game.";
				
		// IF CURRENT_USER HAS REGISTERED EMAIL
		} elseif (isset($_GET["game_id"]) && isset($_SESSION["user_id"])) {
			$list_item_set = find_list_item_by_game($_GET["game_id"]);
			$game = find_game_by_id($_GET["game_id"]);
			echo 	"<h2>". $game["title"]. "</h2>";
			while ($list_item = mysqli_fetch_assoc($list_item_set)) {
				$source_user =  find_user_by_id($list_item["user_id"]);

		
				// CHECKS TO SEE IF RECIPIENT(S) HAVE REGISTERED EMAILS
				if (empty($source_user["email"])) {
					echo $source_user["username"]. " has not provided an email address. <br />";
					
					// IF ALL EMAILS ARE AVAILABLE, DISPLAY LIST ITEM INFO
				} elseif (!empty($source_user["email"]) && !empty($current_user["email"])) {
						echo $source_user["username"]; ?> 
						<br />
						<?php
						if (!empty($list_item["challenge"])) { 
							echo "Challenge: ". $list_item["challenge"];
						} else {
							echo "No Challenge Specified";
						}
				?>
				<br /><br />
				<div id="commit_game">
					<form action="commit_game.php" method="POST">
						<input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
						<input type="hidden" name="source_user_id" value="<?php echo $source_user["id"]; ?>">
						<input type="hidden" name="game_id" value="<?php echo $_GET["game_id"]; ?>">
						Comments <br />
						<textarea cols=40 rows=10 name="comments" placeholder="Use this field to summarize your experience with the game"> </textarea> <br />
						
						<?php
						// DISPLAY CHECKBOXES FOR TAGS (IN DEVELOPMENT)
							$tags = find_tags();
							// echo "<fieldset>";
							while ($tag = mysqli_fetch_assoc($tags)) {
								echo "<div class=\"tag\">";
								echo "<input type=\"checkbox\" name=\"tags[]\" id=\"{$tag["name"]}\" value=\"{$tag["id"]}\"/>";
								echo "</div>";
								echo "<label for=\"tag_{$tag["name"]}\">". $tag["name"]. "</label>";
								echo "<br />";

							}
							//echo "</fieldset>";
						?>
						<input type="submit" name="submit" value="Submit!" onclick="return confirm('Everything look good?')"/>			
					</form>
				</div>
				<hr />
				<br />
		<?php
			}
		}
	}
		?>
	<!-- END OF <div id="menu"> -->
	</div>
	<div id="sidebar">
		<h2>You beat a game?</h2> 
		<p>Yes!( ⁼̴̤̆ ළ̉ ⁼̴̤̆)و ̑̑</p>
		<p>A credits screen, a 'fin', or a kill screen is a good sign. If a user has specified a special challenge for the game, you should check, and choose the challenge you would like to confirm, because...</p>
		<h2>YOU CAN ONLY CONFIRM A GAME ONCE!</h2>
		<p>This is kind of a bummer. I know it is. I wish we could think up a way to get all kinds of crazy points for doing bizarre hijinx in these games. </p>
		<p>The silver lining on this is that if you confirm a challenge, you get a 100pt bonus. It's like a high-five, imagine the other Quester waiting with their hand in the air for months. MONTHS.</p>
	</div>
	<br />
	

<!-- END OF <div class="page"> FROM MNG_USR_HEADER.PHP -->
	<?php include("../includes/footer.php"); ?>
</div>