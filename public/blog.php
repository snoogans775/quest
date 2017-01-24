<div class = "blog">
	<h3>It's almost over</h3>
	<p><i>December 23, 2017</i></p>
	<p>We have played some games. The Quest is now in wintry wonderland mode, and we'll be having a little party in Reno, NV to celebrate and review the games we've played and what we've gained. Anybody with a registered account will be receiving a private email with the location and date. Thanks y'all!
	-Kevin
</div>
<div class="blog">
	<h2> The BEST...aroooooouunnd! </h3>
		<p><i>October 4, 2016</i></p>
		<p>The current Quest leaders are below. You earn points by beating games, but you also get a point bonus when someone beats a game from your list, so keep Questin'!</p>
	<?php
	global $connection;
	$query = "SELECT * ";
	$query .= "FROM users ";
	$query .= "ORDER BY points DESC ";
	// $query .= "LIMIT 5";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	if (mysqli_affected_rows($connection) >= 1) {
		echo '<br />';
		while($user = mysqli_fetch_assoc($user_set)) {
			if ($user['points'] > 400) {
				echo $user['username']. '  :  '. $user['points']. '<br />';					
			}
		}	
	}
	?>
	<hr>
</div>
<div class = "blog">
	<h3>The Quest is real!</h3>
	<p><i>April 18, 2016</i></p>
	<p>First of all, I give so many thanks to Andrew Musselman for all his work on the Quest v1.0. Every single discussion we had was worth it once I started refactoring and translating his original Python into the PHP smorgasbord that you are currently using. Here's a few tips to get you started:</p>
	<ul>Updatez:
		<li>When you register here, your username and password will automagically work on the forums</li>
		<li>Make a list, then follow games, then play games, then confirm completion.</li>
		<li>Remember, these are people's FAVORITE GAMES OF ALL TIME. This is a great opportunity to try something you've never done before.</li>
		<li>A search function for the front page is coming</li>
	</ul>
	-Kevin
</div>