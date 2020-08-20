<?php ini_set('error_reporting', E_ALL); ini_set('display_errors', 1); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/PageBuilder.php"); ?>
<?php $loggedIn = false; ?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html>
<?php
$builder = new PageBuilder();
$header    = $builder->getHeader('public');
$navbar    = $builder->getNavbar();
$greeting  = $builder->getGreeting();
$loginForm = $builder->getLoginForm();

//Render Page components
echo $header;
	
?>
<body>
<?php
	echo $navbar;
	if($loggedIn) 
	{
		echo $greeting;
	}
	else 
	{
		echo $loginForm;
	}
	
	echo $navbar;
?>
