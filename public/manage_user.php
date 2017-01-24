<?php include("../includes/mng_usr_header.php"); ?>

<hr />
	<div id="content">
		<h2><?php echo $username; ?>'s List</h2>
		<p><a href="add_game.php">+ Add a New Game</a></p>
		<?php 
			// False in this function determines value of $public 
			echo display_list($_SESSION["user_id"], false);
		 ?>
	</div>
	<div id="sidebar">
		<h2>Currently Following</h2>
		<?php 
			echo display_followed_games($_SESSION["user_id"]);
		?>
		<hr />
		<h2>Completed Games</h2>
			<!-- ><p>୧༼ಠ益ಠ༽୨ <br /> がんばって！</p> -->
			<?php
			$completion_set = find_completed_games($_SESSION["user_id"]);
			if( mysqli_num_rows($completion_set) == 0) {
				echo 'You have not completed any games';
			} else {
				echo mysqli_num_rows($completion_set). ' Games Completed';
				echo '<ul>';
				while ($completion = mysqli_fetch_assoc($completion_set)) {
					$game = find_game_by_id($completion["game_id"]);
					echo '<li>'. $game["title"]. '</li>';
				}
				echo '</ul>';
			}

			?>
	</div>
	<?php /*
		if(isset($_SESSION["user_id"])) { 
			include("{$current_subject["menu_name"]}.php"); 
		} else {
			include("home.php");
		} */ ?>
<?php include("../includes/footer.php"); ?>
</div>