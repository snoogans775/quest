<?php include("../includes/mng_usr_header.php"); ?>
<?php 
if (isset($_POST["submit"])) {
	//validations
	$required_fields = array("email");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("email" => 50);
	validate_max_lengths($fields_with_max_lengths);
	
	validate_email("email");
	
	if (empty($errors)) {
		global $connection;
		$user_id = mysql_prep($_SESSION["user_id"]);
		$email = mysql_prep($_POST["email"]);
		
		$query  = "UPDATE users "; 
		$query .= "SET ";
		$query .= "email=";
		$query .= "'{$email}' ";
		$query .= "WHERE id = {$user_id}";		
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		
		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Successs
			$_SESSION["message"] .= "Your information has been updated.";
			redirect_to("manage_user.php");
		} else {
			//Failure
			$_SESSION["message"] .= "Update failed. Please contact the webmaster for help.";
			redirect_to("manage_user.php");
		}
	}
}
?>
<!-- BEGIN PAGE CONTENT -->
<a href="manage_user.php">Your Quest ></a>
<a href="user_info.php">Your Info ></a>
<hr />
	<?php 
	if(!empty($_SESSION["message"])) { 
		echo $_SESSION["message"]. "<br />";
		$_SESSION["message"] = "";
	} ?>
	<h2>Update Your Information</h2>
	<p>You will receive an email when another Quester completes a game from your list.</p>
	<p>Your email address will not be disclosed.</p><br />
	<form action="user_info.php" method="POST">
		Email
		<?php 
		$user = find_user_by_id($_SESSION["user_id"]);
		if (isset($user["email"])) {
			echo htmlspecialchars($user["email"]);
		} ?>
		<br />
		<input type="text" name="email" /><br />
		<br />
		<input type="submit" name="submit" value="Update" />
	</form>
<!-- END OF <div class="page"> FROM MNG_USR_HEADER.PHP -->
</div>
<?php include("../includes/footer.php"); ?>			