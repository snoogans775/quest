<?php require_once("../includes/Session.php"); ?>
<?php ini_set('error_reporting', E_ALL); ini_set('display_errors', 1); ?>
<?php require '../vendor/autoload.php'; ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/PageBuilder.php"); ?>
<!DOCTYPE html>
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
	session_start();
	print_r( $_SESSION);
	$builder = new PageBuilder();

	$home = $builder->getHomepage();

	echo $home->saveHTML();
?>

</body>
</html>