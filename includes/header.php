<?php ini_set('error_reporting', E_ALL); ini_set('display_errors', 0); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php require_once("../includes/PageBuilder.php"); ?>
<?php $layout_context = "public"; ?>
<?php find_selected_page(); ?>

<?php
$builder = new PageBuilder();
$header = $builder->getBanner();

//Render Page components

	
?>