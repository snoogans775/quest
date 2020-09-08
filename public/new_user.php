<?php require_once("../includes/session.php"); ?>
<?php include("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $layout_context = "public"; ?>
<?php find_selected_page(); ?>

<?php
if (isset($_POST["submit"])) {
	//validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("username" => 30);
	validate_max_lengths($fields_with_max_lengths);

	validate_email("email");

	match_passwords("password", "password_confirm");
	
	//EMERGENCY VALIDATION QUESTION, FIX WITH A CAPTCHA OR A fUNCTION
	
	$answer = strtolower($_POST["validate"]);
	if ($answer !== "doki") {
		$errors[] = "Please answer the security qustion correctly";
	}
	
	if (empty($errors)) {
		$username = mysql_prep($_POST["username"]);
		$email = mysql_prep($_POST["email"]);
		$hashed_password = password_encrypt($_POST["password"]);

		//performs database query
		$query  = "INSERT INTO users ("; 
		$query .= " username, hashed_password, points, email, date_joined";
		$query .= ") VALUES (";
		$query .= " '{$username}', '{$hashed_password}', 400, '{$email}', NOW() ";
		$query .= ")";
		$result = mysqli_query($connection, $query); 
		//$result will not be a typical variable. It will be a resource.
	
		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Success
			$_SESSION["message"] = "Account Created.";
			redirect_to("new_forum_user.php?user=". $_POST["username"]. "&pass=". $_POST["password"]);
		} else {
			//Failure
			$_SESSION["message"] = "Registration failed.";
			redirect_to("new_user.php");
		}
		
	} else {
	// This is probably a GET request
	// END OF if (isset($_POST["submit"]))	
	}
}

?>
<?php include("../includes/header.php"); ?>
<div class="page">
	<?php 
		if (!isset($_SESSION["username"])) { ?>
			<h1>Create a new user account</h1>
			<div>
				<?php echo form_errors($errors); ?>
				<?php echo $_SESSION["message"]; $_SESSION["message"] = null; ?>
			</div>
			<form action="new_user.php" method="POST">
				<table>
					<tr>
				<td>Username: </td><td><input type="text" name="username" placeholder="ex. vidjyagamesBilly" /></td>
					</tr>
					<tr>
				<td>Email: </td><td><input type="text" name="email" placeholder="ex. praise@vidjya.games"/></td>
					</tr>
					<tr>
				<td>Password: </td><td><input type="password" name="password" placeholder="" /></td>
					</tr>
					<tr>
				<td>Confirm Password: </td><td><input type="password" name="password_confirm" placeholder="" /></td>
					</tr>
					<tr>
						<td>Fill in The Blank: Doki _____ Panic </td><td><input type="validate" name="validate" value="" /></td>
					</tr>
				</table>
				
				<input type="submit" name="submit" value="Register" />
			</form>
		<?php } else {
			echo "<p>Please log out before creating a new user. And please don't make more than one user account. It is poor form. Very poor.</p>";
		} ?>
	
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>