<h1>The Quest has Ended</h1>
</div>
<div id="content">
	<div> 
		<form action="" method="POST">
			<select name="platform_sort">
			<option selected>All Platforms</option>
			<?php 
			$platform_set = find_all_platforms();
			while($platform = mysqli_fetch_assoc($platform_set)) {
				echo "<option>{$platform["name"]}</option>"; 
			} ?>
		</select>
		<input type="submit" name="submit" value="Sort" />
	</form>  
	</div>
	<?php 
	// Checks for sort variable
		if (isset($_POST["submit"]) && $_POST["platform_sort"] !== "All Platforms") { 
			echo $_POST["platform_sort"]. "<br />";
			
			display_list_by_platform();
			
		} else {
			// Display all lists, listing users in order of user_id
			$user_set = find_all_users();
			while($user = mysqli_fetch_assoc($user_set)) {
				$current_user = mysqli_fetch_assoc(find_list_by_user($user["id"]));
				if (!empty($current_user)) {
					echo $user["username"];
					echo display_list($user["id"]);
				}
			}
		}
	?>
</div>
<div id="blog">
	<?php include("blog.php"); ?>
</div>