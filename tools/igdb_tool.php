<?php
function igdb_cover($title) {
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
if (isset($_POST["submit"])) {

}
	?> 
<html>
<head>
	<title>IGDB test</title>
</head>
<body>
	
	<h1>IGDB Title Search</h1>
	<form action="" method="POST">
		<input type="text" name="title" />
		<input type="submit" name="submit" value="submit">
	</form>
	
	<div style="width: 400px">
	

	<?php 
	$image = igdb_cover($_POST["title"]);
	
	echo "<img src=\"". $image. "\"></img>"; 
	?>

	</div>
</body>
</html>