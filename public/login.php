<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
$username = "";
if (isset($_POST["submit"])) {
	$username = strtoupper($_POST["username"]);
	$password = $_POST["password"];
	$found_user = attempt_login($username, $password);
	
	//validations
	// $required_fields = array("username", "password");
	// validate_presences($required_fields);
	
	if (empty($errors)) {
		
		if($found_user) {
			// Success
			$_SESSION["user_id"] = $found_user["id"];
			$_SESSION["username"] = $found_user["username"];
			$_SESSION["points"] = $found_user["points"];
			redirect_to("manage_user.php");
		} else {
			// Failure
			$_SESSION["message"] = "Username/password not found.";
			redirect_to("index.php");
		}
	} else {
		redirect_to("index.php");
	}
} else {
	// Likely a GET request
}
?>

	<?php include("../includes/footer.php"); ?>
	
</div>
</body>
</html>