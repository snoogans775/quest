<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php
if ($_POST["submit"]) {

	$subject = "Quest News for ". date("M Y");

	//modfiable intro
	$intro = "Well, it has been an exciting Spring. The new website for the Quest is up and running, and I'm still working on some bugs and features. There's more to do all the time and I look forward to all the possible improvements and tweaks available to make The Quest more fun. Thank you for taking part in this adorable little project. <br /><br />-Kevin<br /><br />";

	$users = find_all_users();
	$followed_games = find_all_followed_games();
	$followed_games_assoc = array();

	//adds all followed game id's to array
	while($item = mysqli_fetch_assoc($followed_games)) {
		$followed_games_assoc[] = $item["game_id"];
	}

	// Begins moving through each user
	while ($user = mysqli_fetch_assoc($users)) {
		echo $user["username"]. ' via ';
		echo $user["email"]. '<br />';
		$body  = '<h2>Update for '. date('M Y'). '</h2>';
		$body .= $intro;
		$body .= '<h3>News From Your Quest: </h3>';
	
		// Checks if any games from the user's list are being followed
		$list_set = find_list_by_user($user["id"]);
		while ($list_item = mysqli_fetch_assoc($list_set)) {
			if (in_array($list_item["game_id"], $followed_games_assoc)) {
				$body .= $list_item["title"]. " is being followed by another Quester!<br/>";
			}
		}
		$body .= "You currently have a score of ". $user["points"];
		$body .= "<br />";
		$body .= "<img src=\"http://www.rvgsymphony.com/quest/public/images/mic.jpg\"></img><br /><br />";
		$body .= 'If you would like to be on our new podcast, send me an email at kevin@rvgsymphony.com. <br />I am interested in talking to people about the games on their list.<br />';
		$body .= "<br />";
		$body .= "See you next month, and remember, we are all subject to the Quest<br />";
		
		echo $body;
		//safety comment
		
		// send_email($subject, $body, $user["email"]);
	}
}
?>
<html>
<head>
	<title>Newsletter</title>
</head>
<body>
<form action="" method="POST">
	<input type="submit" name="submit" value="Send Monthly Email">
</form>