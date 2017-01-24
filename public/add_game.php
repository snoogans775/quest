<?php include("../includes/mng_usr_header.php"); ?>


<?php
if (isset($_POST["submit"])) {
	//validations
	$required_fields = array("title", "platform");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("title" => 40, "challenge" => 20);
	validate_max_lengths($fields_with_max_lengths);
	
	$game = find_game_by_title($_POST["title"]);
	$title = mysql_prep($_POST["title"]);
	$platform = mysql_prep($_POST["platform"]);
	$challenge = mysql_prep($_POST["challenge"]);
	
	// Inserts game data into user's list, returns existing id if game already exists
	if (empty($errors)) {
		// Makes sure the game has not been entered already. This does not check for misspellings. It only checks the string as provided by the user.
			$query  = "INSERT INTO games ("; 
			$query .= " title, platform";
			$query .= ") VALUES (";
			$query .= " '{$title}', '{$platform}' ";
			$query .= ")";
			$result = mysqli_query($connection, $query); 
		
			if ($result && mysqli_affected_rows($connection) >= 0) {
				//Success
				$safe_title = htmlspecialchars($title);
				$_SESSION["message"] = "{$safe_title} added to database. "; 
			} else {
				//Failure
				$_SESSION["message1"] = "Game Already Entered into database. ";
			}
		// Inserts into relational table. This identifies the game with the user.	
		// Once again, game is the only table that uses the syntax game_id. Sigh.
		$game = find_game_by_title($_POST["title"]);
		$user_id = mysql_prep($_SESSION["user_id"]);
		$game_id = mysql_prep($game["game_id"]);

		$query  = "INSERT IGNORE INTO users_games ("; 
		$query .= " user_id, game_id, challenge";
		$query .= ") VALUES (";
		$query .= " {$user_id}, {$game_id}, '{$challenge}' ";
		$query .= ")";
		$result = mysqli_query($connection, $query); 
		//$result will not be a typical variable. It will be a resource.

		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Successs
			$_SESSION["message"] .= "<br />Your list has been updated.";
			redirect_to("add_game.php");
		} else {
			//Failure
			$_SESSION["message"] .= "Game Not Entered. Please contact the webmaster for help";
			redirect_to("add_game.php");
	  } 
	}
}	// This is probably a GET request 
// END OF if (isset($_POST["submit"]))
?>
<!-- BEGIN PAGE CONTENT -->
<a href="manage_user.php">Your Quest ></a>
<a href="add_game.php">Add Game ></a>
<hr />
	<span id="menu">
		<h2>Add a game to Your List</h2>
		<form action="add_game.php" method="POST">
			Title
			<br />
			<input type="text" name="title" /><br />
			Platform <br />
			<select name="platform">
				<option selected></option>
				<?php 
				$platform_set = find_all_platforms();
				while($platform = mysqli_fetch_assoc($platform_set)) {
					echo "<option>{$platform["name"]}</option>";
				} ?>
			</select>
			<br />
			<!-- Drop-down content to add a challenge to a game -->
			<ul>
				<li class="title">
					+ Add a challenge?
					<div class="add_challenge">
						Useful if your game does not have an ending.
						<br />
						Keep descriptions less than 20 characters.
						<input type="text" name="challenge" placeholder="Describe your challenge" />
					</div>
				</li>
			</ul>
			<input type="submit" name="submit" value="Add Game" />
		</form>
	</span>
	<span id="sidebar">
		<div class="list">
			<h3><?php echo $username; ?>'s List</h3>
		<?php 
			echo display_list($_SESSION["user_id"], false);
		 ?>
	 	</div>
	</span>
	
</div>
<!-- END OF <div class="page"> FROM MNG_USR_HEADER.PHP -->
<?php include("../includes/footer.php"); ?>