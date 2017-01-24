<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $layout_context = "public"; ?>
<?php find_selected_page(); ?>

<?php
if (isset($_POST["submit"])) {
	//validations
	$required_fields = array("name");
	validate_presences($required_fields);
	
	if (empty($errors)) {
		$name = mysql_prep($_POST["name"]);

		//performs database query
		$query  = "INSERT INTO platforms ("; 
		$query .= " name";
		$query .= ") VALUES (";
		$query .= " '{$name}'";
		$query .= ")";
		$result = mysqli_query($connection, $query); 
		//$result will not be a typical variable. It will be a resource.
	
		if ($result && mysqli_affected_rows($connection) >= 0) {
			//Success
			$_SESSION["message"] = "Platform Entered.";
			redirect_to("new_platform.php");
		} else {
			//Failure
			$_SESSION["message"] = "Add failed.";
			redirect_to("new_platform.php");
	  }
	} 
} else {
	// This is probably a GET request
	// END OF if (isset($_POST["submit"])) {
}
?>

<?php include("../includes/header.php"); ?>
<div class="page">
	<?php echo $_SESSION["message"]; ?>
			<h1>ADMIN shizz - Add platforms</h1>
			<div>
				<?php echo form_errors($errors); ?>
			</div>
			<form action="new_platform.php" method="POST">
				<input type="text" name="name" placeholder="name" /><br />

				<br />
				
				<input type="submit" name="submit" value="Register" />
			</form>

	<?php include("../includes/footer.php"); ?>
	
</div>
</body>
</html>