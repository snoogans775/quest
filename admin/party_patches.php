<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php function igdb_cover($title) {
	$title = urlencode($title);
	// determine Game ID
	// the id's of games should be stored locally, this would prevent the extra request
	$url  = "https://igdbcom-internet-game-database-v1.p.mashape.com/games/?search=";
  $url .= $title;

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-Mashape-Key: GoaKiXZhO2mshIteyk8g163yoUdup1Vbo91jsnTJo8PhLfcXWP'));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec ($curl);
	curl_close($curl);

	//converts the json array

		$game_set = json_decode($result, true); 
		$id = $game_set[0]["id"];
		
		$image_url  = "https://igdbcom-internet-game-database-v1.p.mashape.com/games/";
		$image_url .= $id;
		$image_url .= "?fields=cover";

		$curl = curl_init($image_url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-Mashape-Key: GoaKiXZhO2mshIteyk8g163yoUdup1Vbo91jsnTJo8PhLfcXWP'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		curl_close($curl);

		//converts the json array

			$image_set = json_decode($result, true); 
			$image_location = $image_set[0]["cover"]["url"];
			
			return $image_location;
}
?>
<?php 
$user_set = find_all_users();

//Displays images of each game on each user's list, very request-heavy on igdb
 
  while($user = mysqli_fetch_assoc($user_set)) {
	$list = find_list_by_user($user["id"]);
	if(!empty($list)) {
		$output  = "<h1>". $user["username"]. "</h1>";
		$output .= "<br />";

		while($game = mysqli_fetch_assoc($list)){
			//$output .= $game["title"]. "<br />";
			$output .= "<img src=\"";
			$output .= igdb_cover($game["title"]);
			$output .= "\"></img>";
		}
		$output .= "<hr>"; 
		echo $output;
	}
} 


/*
while($user = mysqli_fetch_assoc($user_set)) {
	$completion_set = find_completed_games($user["id"]);
	if( mysqli_num_rows($completion_set) != 0) {
		echo "<h1>{$user["username"]}</h1>";
		echo mysqli_num_rows($completion_set). ' Games Completed';
		echo '<ul>';
		while ($completion = mysqli_fetch_assoc($completion_set)) {
			$game = find_game_by_id($completion["game_id"]);
			echo '<li>'. $game["title"]. '</li>';
		}
		echo '</ul>';
	}
}

*/
?>
