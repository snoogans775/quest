<?php include("../includes/header.php"); ?>
<!-- Show game metadata and list games by platform/ year released -->
<?php
$game_set = find_all_games();
//$game_array = mysqli_fetch_assoc($game_set);
// $game_data = igdb_by_title($game_array[0]["title"]);

echo gettype($game_set);
		
/*		
		global $connection;

		$query  = "INSERT INTO igdb ";
		$query .= "(igdb_id, summary, primary_genre, secondary_genre,".
								" themes, release_date, platform, developer, cover_url,". 
								" quest_id";
		$query .= ") VALUES (";
		$query .= ""
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);	
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}
}
*/
?>