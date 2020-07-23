<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>

<?php
if ($_POST["submit"] && $_POST["password"] == "newsletter") {

	$subject = "Quest PARTY TIME ";

	//modfiable intro
	// archived Jun 2016 
	//$intro = "Well, it has been an exciting Spring. The new website for the Quest is up and running, and I'm still working on some bugs and features. There's more to do all the time and I look forward to all the possible improvements and tweaks available to make The Quest more fun. Thank you for taking part in this adorable little project. <br /><br />-Kevin<br /><br />";
	//archived sep 2016
	//"<p>Thank you so much for your contributions to the Quest. June was a slow and steady month. I really enjoyed playing Crash Bandicoot 2 from AdmiralKisu's list. There were some design elements in Crash Bandicoot that reminded me of the collapsing structures in Uncharted 2 and 3. It's amazing what Naughty Dog has done! I'll catch you all again next month, and until then you can pop on the forums!</p>-Kevin";
	// archived Aug 2016
	// $intro = '<p>To be honest, July was a quiet month at the Quest. Nevertheless, a few people finished some massive games. Big credit to Tuna On Rye for finishing Half Life 2, as well as Episode 1 and 2. </p><p> In other news, a new feature has appeared! You can now tag games with adjectives upon completion. This will be used to create a profile of the game, and in the future we will be creating a feature that will help you create your "gaming personality", which will help you find new games that both complement and challenge your tastes. Thanks for all the questing, life and love.  -Kevin</p>';
	// $intro = "<p>The Quest has been going strong all Summer, and here in Reno, video games are the best complement to the cold Winter months. It has been rumored that Reno has a fall season but I believe it's a myth, while, yes, some nice breezes and foliage can be seen, I am more familiar with a sudden shift from 80 degree days to extreme survivalist snowstorms.</p>
	//<p>Fewer games were completed in August than usual, but I know AdmiralKisu is working on Resident Evil 1 from Tuna on Rye's list, and I'm still cracking away at Final Fantasy Tactics, so I look forward to seeing how those bigger games turn out. Thanks for Questin' Life and Love!</p>";
	$intro = "Thanks for Questing this year! Time for party time. In Reno, where about 2/3rd of all Questers live.<br />At my house, we will eat many sweetmeats and delicious libations. All ages btw. <br />There will be prizes, vidjyagames, and great presentation of data. sweet, delicious data. 
	<br /><br />WHERE: 3355 Barbara Circle, Reno, NV 89523
	<br /><br />WHEN: FRIDAY, January 13th @ 6:00pm-7:00pm and beyond
	<br />
		check out the facebook event at <a href=\"https://www.facebook.com/events/376346136059481/\">THE FACEBOOK EVENT</a>.
		<br /><br /><Send an email to kevin@rvgsymphony with any questions.";

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
		# $body .= "You currently have a score of ". $user["points"];
		$body .= "You ended the Quest with a score of ". $user["points"];
		$body .= "....". ($user["points"] < 500 ? "hmmmm" : "amazing.");
		$body .= "<br />";
		$body .= "<img src=\"http://www.rvgsymphony.com/quest/public/images/mic.jpg\"></img><br /><br />";
		#$body .= 'If you would like to be on our new podcast, send me an email at kevin@rvgsymphony.com. <br />I am interested in talking to people about the games on their list.<br />';
		$body .= 'Thank you to everybody that contributed to the podcast, there are still a few of you I\'d like to talk to so I will be reaching out. Now to edit the audio and make some jurnalizms.';
		$body .= "<br />";
		$body .= "See you next year, and remember, we are all subject to the Quest<br />";
		

		//safety comment
		
		send_email($subject, $body, $user["email"]);
		
	}
	echo $body;
}
?>
<html>
<head>
	<title>Newsletter</title>
</head>
<body>
<form action="" method="POST">
	password: <input type="password" name="password" value=""> <br />
	<input type="submit" name="submit" value="Send Monthly Email">
</form>