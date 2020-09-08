<?php require_once("../includes/Session.php"); ?>
<?php require_once("../includes/Database.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/Authenticator.php"); ?>

<?php
if (isset($_POST["submit"])) {
	$db = new Database();
	$auth = new Authenticator($db->getConnection());

	$username = strtoupper($_POST["username"]);
	$password = $_POST["password"];
	$foundUser = $auth->attemptLogin($username, $password);

	//Validations
	
	if (empty($auth->errors)) {
		
		if($foundUser) {
			// Success
			$_SESSION["user_id"] = $foundUser["id"];
			$_SESSION["username"] = $foundUser["username"];
			$_SESSION["points"] = $foundUser["points"];
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