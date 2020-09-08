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
		<h2>Completed Games</h2>
			<?php display_completed_games($_SESSION["user_id"]); ?>
	</div>
	<?php /*
		if(isset($_SESSION["user_id"])) { 
			include("{$current_subject["menu_name"]}.php"); 
		} else {
			include("home.php");
		} */ ?>
<?php include("../includes/footer.php"); ?>
</div>