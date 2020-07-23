<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php date_default_timezone_set('America/Los_Angeles'); ?>

<?php
if ($_POST["submit"] && $_POST["password"] == "newsletter") {

	$subject = "Quest News for ". date("M Y");

	//modfiable intro
	// archived Jun 2016 
	//$intro = "Well, it has been an exciting Spring. The new website for the Quest is up and running, and I'm still working on some bugs and features. There's more to do all the time and I look forward to all the possible improvements and tweaks available to make The Quest more fun. Thank you for taking part in this adorable little project. <br /><br />-Kevin<br /><br />";
	//archived sep 2016
	//"<p>Thank you so much for your contributions to the Quest. June was a slow and steady month. I really enjoyed playing Crash Bandicoot 2 from AdmiralKisu's list. There were some design elements in Crash Bandicoot that reminded me of the collapsing structures in Uncharted 2 and 3. It's amazing what Naughty Dog has done! I'll catch you all again next month, and until then you can pop on the forums!</p>-Kevin";
	// archived Aug 2016
	// $intro = '<p>To be honest, July was a quiet month at the Quest. Nevertheless, a few people finished some massive games. Big credit to Tuna On Rye for finishing Half Life 2, as well as Episode 1 and 2. </p><p> In other news, a new feature has appeared! You can now tag games with adjectives upon completion. This will be used to create a profile of the game, and in the future we will be creating a feature that will help you create your "gaming personality", which will help you find new games that both complement and challenge your tastes. Thanks for all the questing, life and love.  -Kevin</p>';
	//$intro = "<p>The Quest has been going strong all Summer, and here in Reno, video games are the best complement to the cold Winter months. It has been rumored that Reno has a fall season but I believe it's a myth, while, yes, some nice breezes and foliage can be seen, I am more familiar with a sudden shift from 80 degree days to extreme survivalist snowstorms.</p>
	//<p>Fewer games were completed in August than usual, but I know AdmiralKisu is working on Resident Evil 1 from Tuna on Rye's list, and I'm still cracking away at Final Fantasy Tactics, so I look forward to seeing how those bigger games turn out. Thanks for Questin' Life and Love!</p>";
	$intro = '<h1>I AM RISEN!!!</h1><img src="https://i.ytimg.com/vi/0Bx00WFVq-A/hqdefault.jpg" /><p>It has been a while, hasn\'t it? Well I feel like we have not talked in ages!! How are you doing, what is new?</p><p>It may feel as if the Quest has completely disappeared from the world. And yeah, the hiatus has been a bit long this year. 7 months is way too long and a lot of folks like playing video games so alas the Quest returns!</p><h1>NEW NEWS FOR THE QUEST</h1><p>I have implemented a few nice changes in the new version of the site, and with a little help we could get it on the Apple App Store and Google Play. That would be convenient for us all. However, the most important change is a twitch streaming channel for Questers. If you know anything about streaming, please contact me, Kevin, the Questmaestro at <strong>kevin@rvgsymphony.com</strong>.</p><h1>Quest Sadness</h1><p>The greatest shock to the Quest came earlier this year when we lost 2-time Quest Champion Jasmine Overli. She very missed. I am still very sad and I miss Jasmine. So now that I am comfortable saying her name out loud again, I thought this would be an excellent year to play the games that Jasmine loved.</p><h2>All right, that is all for now. The next email you get from me will be the one that sets the next Quest in motion.';

	$users = find_all_users();
	$followed_games = find_all_followed_games();
	$followed_games_assoc = array();

	//adds all followed game ids to array
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
		//$body .= 'If you would like to be on our new podcast, send me an email at kevin@rvgsymphony.com. <br />I am interested in talking to people about the games on their list.<br />';
		//$body .= "<br />";
		$body .= "See you soon, and remember, we are all subject to the Quest.<br />";
		

		//safety comment
		
		send_email($subject, $body, $user["email"]);
		
	}
	echo $intro;
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