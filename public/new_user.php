<?php require __DIR__ . "/../vendor/autoload.php"; ?>
<?php ini_set('error_reporting', E_ALL); ini_set('display_errors', 1); ?>
<html>
<head>
	<meta charset="utf-8"></meta>
	<title>The Quest</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" type="text/css"
	      href="https://fonts.googleapis.com/css?family=IM+Fell+Great+Primer|Nunito|Averia+Sans+Libre" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
<?php 

<<<<<<< HEAD
$db = new Database();
$db->setDefaultConnection();
=======
<?php
if (isset($_POST["submit"])) {
	//validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("username" => 30);
	validate_max_lengths($fields_with_max_lengths);
>>>>>>> heroku-dev

if( isset($_SESSION)) { print_r( $_SESSION ); }

if (isset($_POST["submit"])) { $db->addUser($_POST); }

<<<<<<< HEAD
?>
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
		</table>
		
		<input type="submit" name="submit" value="Register" />
	</form>
=======
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
		} else {
			//Failure
			$_SESSION["message"] = "Registration failed.";
		}
		redirect_to("new_user.php");
		
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
>>>>>>> heroku-dev
</body>
</html>