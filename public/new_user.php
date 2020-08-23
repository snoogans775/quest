<?php require_once("../includes/Database.php"); ?>
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

$db = new Database();
$db->setDefaultConnection();

if( isset($_SESSION)) { print_r( $_SESSION ); }

if (isset($_POST["submit"])) { $db->addUser($_POST); }

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
</body>
</html>