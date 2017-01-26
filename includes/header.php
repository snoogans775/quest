<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $layout_context = "public"; 
?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>The Quest</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" type="text/css"
	      href="https://fonts.googleapis.com/css?family=IM+Fell+Great+Primer|Nunito|Averia+Sans+Libre">
				<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
</head>
<body>
	<div class="body">
		<div class="header">
			<div id="banner">
				<a href="index.php"><img src="../public/images/quest_logo.png"></img></a>
			</div>
			<div class="login">
			<?php // echo login_form(); ?>
			<?php 
			if (!isset($_SESSION["username"])) { ?>	
				<form action="login.php" method="POST">
					<input type="text" placeholder="username" name="username" /><br />
					<input type="password" placeholder="password" name="password" /><br/>
					<span>
						<input type="submit" name="submit" value="login" />
				</form>
						<a href="new_user.php">&nbsp &nbsp New To The Quest?</a>
					</span>
			<?php } else { ?> 
				<span id="greeting">
					Hello, <?php echo $_SESSION["username"]; ?> 
				</span>
				<span id="logout">
					<a href="logout.php">Logout</a>
				</span>
 				<br />
				Points: 
				<?php 
					$current_user = find_user_by_id($_SESSION["user_id"]);
					echo $current_user["points"]; ?> 
				<br />
				<span id="mini_menu">
					<a href="manage_user.php?id=<?php echo $_SESSION["user_id"]; ?>">Your Quest</a>
				</span>
			<?php } ?>
			</div>
			<div class="navbar">
					<?php echo navigation($current_subject, $current_page); ?>
			</div>
		</div>
		<hr />