<?php include("../includes/mng_usr_header.php"); ?>

<?php
	if (isset($_POST["submit"])) {
		$title = $_POST["title"];
		$platform = $_POST["platform"];
		$challenge = $_POST["challenge"];
		
		print_r($_SESSION);
	
		add_game_to_list($title, $platform. $challenge);
	}	// This is probably a GET request 
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