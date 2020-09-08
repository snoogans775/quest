<?php
	
	// UTILITY AND DATABASE FUNCTIONS //

	function redirect_to($new_location) {
		//header("Location: " . $new_location);
		echo "<script type='text/javascript'> document.location = '{$new_location}'; </script>";
		exit;
	}
	
	function mysql_prep($connection, $string) {
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	function highlight_errors() {
		global $errors;
		$output = "<div class=\"";
		if ($errors) {
			$output .= "input_error";
		}
		$output .= "\">";
		return $output;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}
	
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
			$output .= "<font color=\"red\">";
		  $output .= "<div class=\"error\">";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
			$output .= "</font>";
		}
		return $output;
	}
	
	// NAVIGATION FUNCTIONS //
	
	function find_all_subjects($connection) {
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		// if ($public){
		//	$query .= "WHERE visible = 1 ";
		// }
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);	
		return $subject_set;
	}
	
	function find_default_page_for_subject($subject_id) {
		$page_set = find_pages_for_subject($subject_id);
		if($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return null;
		}	
	}
	
	function find_pages_for_subject($subject_id, $public=true) {
		global $connection;

		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE subject_id = {$subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);	
		return $page_set;
	}
	
	function find_subject_by_id($subject_id, $public=true) {
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);	
		if($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}
	
	function find_page_by_id($page_id, $public=true) {
		global $connection;
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = {$safe_page_id} " ;
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		if($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}
	
	function find_selected_page($public=false) {
		global $current_subject;
		global $current_page;
		if (isset($_GET["subject"])) {
			$current_subject = find_subject_by_id($_GET["subject"], $public); 
			if ($public) {
			$current_page = find_default_page_for_subject($current_subject["id"]);				
			} else {
				$current_page = null;
			}

		} elseif (isset($_GET["page"])) {
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"], $public); 
		} else {
			$selected_subject_id = null;
			$selected_page_id = null;
		}
	}
	
	// USER FUNCTIONS //
	
	function find_all_users($connection) {
		$query = "SELECT * ";
		$query .= "FROM users ";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);	
		return $user_set;
	}
	
	function find_user_by_id($user_id) {
		global $connection;

		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE id = {$user_id} ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);	
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}
	
	function find_user_by_username($username) {
		global $connection;
		
		$safe_user = mysqli_real_escape_string($connection, $username);

		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE username = '{$safe_user}' ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);	
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}
	
	// navigation takes two arguments
	// - the current subject array or null
	// - the current page array or null
	
	function navigation($connection, $subject_array) {
		global $layout_context;
		$output = "";
		if ($layout_context == "public") {
			$output .= "<ul class=\"navbar\">";
			$subject_set = find_all_subjects($connection);
			while($subject = mysqli_fetch_assoc($subject_set)) {
				$output .= "<li";
				// $subject_array is the first argument for this function, it will be the current subject
				if ($subject_array && $subject["id"] == $subject_array["id"]) {
					$output .= " class=\"selected\"";
				}
				$output .= ">";
				$output .= "<a href=\"index.php?subject=";
				$output .= urlencode($subject["id"]);
				$output .= "\">";
				$output .= htmlentities($subject["menu_name"]);
				$output .= "</a>";
				$output .= "</li>"; //end of subject <li>
			} // end of while($subject =...)
			mysqli_free_result($subject_set); 
			$output .= "</ul>";
			return $output;
		
		}
	}
	
	function login_form($current_user) {
		$output = '';

		if (!isset($_SESSION["username"])) { 
			//FIXME: SPAN IS ACROSS ANOTHER TAG
			$output  = '
				<form action="login.php" method="POST">
					<input type="text" placeholder="username" name="username" /><br />
					<input type="password" placeholder="password" name="password" /><br/>
					<span>. 
					<input type="submit" name="submit" value="login" />
				</form>
				<a href="new_user.php">&nbsp &nbsp New To The Quest?</a>
				</span>';
		} else {
			$output .= '<span id="greeting">Hello, ';
			$output .= $_SESSION["username"];
			$output .= '</span>';
			$output .= '<span id="logout">
										<a href="logout.php">Logout</a>
									</span>
									<br />
									Points:';
			$output .= $current_user["points"];
			$output .= '<br />
									<span id="mini_menu">
										<a href="manage_user.php?id=<?php echo $_SESSION["user_id"]; ?>">Your Quest</a>
									</span>';
		}
		return $output;
	}

	//QUEST DATABASE FUNCTIONS //
	
	function find_game_by_id($game_id) {
		global $connection;
		$safe_game_id = mysqli_real_escape_string($connection, $game_id);
		
		$query  = "SELECT * ";
		$query .= "FROM games ";
		$query .= "WHERE game_id = {$safe_game_id} " ;
		$query .= "LIMIT 1";
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);
		if($game = mysqli_fetch_assoc($game_set)) {
			return $game;
		} else {
			return null;
		}
	}
	
	function find_game_by_title($game_title) {
		global $connection;
		$safe_game_title = mysqli_real_escape_string($connection, $game_title);
		
		$query  = "SELECT * ";
		$query .= "FROM games ";
		$query .= "WHERE title = '{$safe_game_title}' " ;
		$query .= "LIMIT 1";
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);
		if($game = mysqli_fetch_assoc($game_set)) {
			return $game;
		} else {
			return null;
		}
	}
	
	function find_all_games() {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM games ";
		$query .= "ORDER BY title";
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);	
		return $game_set;
	}
	
	function find_list_item($connection, $user_id, $game_id, $table="users_games") {
		// games.game_id is the only column in the database that uses this naming scheme. I wish it
		// wasn't. I really do. Changing it simply does not jibe with these functions for some reason.
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		$safe_game_id = mysqli_real_escape_string($connection, $game_id);
		
		$query  = "SELECT * ";
		$query .= "FROM {$table} ";
		$query .= "WHERE user_id = {$safe_user_id} " ;
		$query .= "AND game_id = {$safe_game_id} ";
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);
			return $game_set;
	}
	
	function find_followed_games_by_user($user_id) {
		// games.game_id is the only column in the database that uses this naming scheme. I wish it
		// wasn't. I really do. Changing it simply does not work with this function for some reason.
		global $connection;
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		
		$query  = "SELECT * ";
		$query .= "FROM games ";
		$query .= "INNER JOIN currently_following "; 
		$query .= "ON games.game_id = currently_following.game_id ";
		$query .= "INNER JOIN users ";
		$query .= "ON users.id = currently_following.user_id ";
		$query .= "WHERE id = {$safe_user_id} " ;
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);
			return $game_set;
	}
	
	function find_all_followed_games() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM currently_following ";
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);
			return $game_set;
	}
	
	function display_followed_games($user_id) {
		//$game_set is the user's followed games as found in currently_following
		$game_set = find_followed_games_by_user($user_id);
		$output = "<ul>";
			while($game = mysqli_fetch_assoc($game_set)) {
				
				$output .= "<li>";
				$output .= "<a href=\"commit_game.php?game_id=". htmlspecialchars($game["game_id"]). "\">";
				$output .= "<img src=\"images/complete_button.jpg\"></img></a>";
				$output .= htmlentities($game["title"]);
				$output .= "<div class=\"drop_content\">";
				// Dregs up the info of the users that have listed the game.
				$list_item_set = find_list_item_by_game($game["game_id"]);
				while($list_item = mysqli_fetch_assoc($list_item_set)) {
					$output .= "<table><tr><td>";
					$user = find_user_by_id($list_item["user_id"]);
					$output .= htmlentities($user["username"]). "";
					$output .= ($list_item["challenge"]) ? " (". htmlentities($list_item["challenge"]). ")" : "";
					$output .= "</td>";
					$output .= "</tr></table>";
				}
				$output .= "Platform:<br />&nbsp&nbsp" .htmlentities($game["platform"]). "<br />";

				// Security vulnerability. using cURL could make this better.
				 $output .= "<br /><form action=\"delete_follow.php\" method =\"POST\">
					<input type=\"hidden\" name=\"user_id\" value=\"{$_SESSION["user_id"]}\" />
					<input type=\"hidden\" name=\"game_id\" value=\"{$game["game_id"]}\" />";
				$output .= "<input type=\"submit\" name=\"submit\" value =\"Stop following?\" /></form>"; 
				// End of <div class="drop-content">
				$output .= "</div>";
				$output .= "</li>";
			}
		$output .= "</ul>";
		return $output;
	}
	
	function find_list_by_user($connection, $user_id) {
		// games.game_id is the only column in the database that uses this naming scheme. I wish it
		// wasn't. I really do.
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		
		$query  = "SELECT DISTINCT games.* ";
		$query .= "FROM games ";
		$query .= "INNER JOIN users_games ";
		$query .= "ON games.game_id = users_games.game_id ";
		$query .= "INNER JOIN users ";
		$query .= "ON users.id = users_games.user_id ";
		$query .= "WHERE id = {$safe_user_id} " ;
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);
		
		return $game_set;
	}
	
	function find_list_item_by_game($game_id, $table="users_games") {
		// games.game_id is the only column in the database that uses this naming scheme.
		global $connection;
		$safe_game_id = mysqli_real_escape_string($connection, $game_id);
		
		$query  = "SELECT * ";
		$query .= "FROM {$table} ";
		$query .= "WHERE game_id = {$safe_game_id} " ;
		$game_set = mysqli_query($connection, $query);
		confirm_query($game_set);
			return $game_set;
	}
	
	// display_list() and display_list_by_platform should be refactored and merged
	function display_list_by_platform() {
		$game_set = find_all_games();
		while($game = mysqli_fetch_assoc($game_set)) {
			
			// $haystack is used to check if the game has already appeared, this is a band-aid.
			$haystack = array();
			if ($game["platform"] == $_POST["platform_sort"]) {
				if (!in_array($game["title"], $haystack)) {
					$haystack[] = $game["title"];
				
					// Copied from display_list()
					$output = "<ul>";
					$output .= "<li class=\"title\">";
					$output .= "<a href=\"follow_game.php?game_id=" .$game["game_id"]. " \"";
					$output .= "onclick=\"return confirm('Follow this game?')\" >";
					$output .= "<img src=\"images/follow_button.jpg\"></img></a>";
					$output .= htmlentities($game["title"]);					
					$output .= "<div class=\"drop_content\">"; 
				
					// Returns list items for this game, then displays usernames
					$list_item_set = find_list_item_by_game($game["game_id"]);
					while ($list_item = mysqli_fetch_assoc($list_item_set)) {
							$user = find_user_by_id($list_item["user_id"]);
							$output .= $user["username"] . ", ";
					}
					substr($output, 0, -3);
					$output .= "</div></li>";
					$output .= "</ul>";
					echo $output;
					}
				} else {
				}
			} // End of if isset($_POST["submit"])
	}
	
	function display_list($connection, $user_id, $public = true) {
		$game_set = find_list_by_user($connection, $user_id);

			$output = "<ul>";
			while($game = mysqli_fetch_assoc($game_set)) {
				$output .= "<li class=\"title\">";
				if ($public == true) {
					$output .= "<a href=\"follow_game.php?game_id=" .$game["game_id"]. " \"";
					$output .= "onclick=\"return confirm('Follow this game?')\" >";
					$output .= "<img src=\"images/follow_button.jpg\"></img></a>";
					//Displays the delete button. Needs security improvement.
				} elseif ($public == false) {
					$output .= "<a href=\"delete_list_item.php?game_id=" .$game["game_id"];
					$output .= "&user_id=". $_SESSION["user_id"]. "\"";
					$output .= " onclick=\"return confirm('Remove this game from your list?')\" >";
					$output .= "<img alt=\"delete\" src=\"images/delete_button.jpg\"></img></a>"; 
				} 
				$output .= htmlentities($game["title"]);
				$output .= "<div class=\"drop_content\">"; 
				$output .= "Platform: " .htmlentities($game["platform"]);  //Platform for game, not unique to user
				// Returns list item for this user only
				$list_item = mysqli_fetch_assoc(find_list_item($connection, $user_id, $game["game_id"]));
				if ($list_item["challenge"]) {
				$output .= "<br />";
				$output .= "Challenge: " .htmlentities($list_item["challenge"]);
				} 
				$output .= "</div></li>";
			}
		$output .= "</ul>";
		return $output;
	}
	
	function find_all_platforms() {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM platforms ";
		$query .= "ORDER BY name";
		$asset = mysqli_query($connection, $query);
		confirm_query($asset);	
		return $asset;
	}
	
	function find_completed_games($user_id) {
		global $connection;
		$query = "SELECT DISTINCT * ";
		$query .= "FROM completion_commits ";
		$query .= "WHERE user_id = $user_id ";
		$query .= "AND confirmed = 1 ";
		$asset = mysqli_query($connection, $query);
		confirm_query($asset);	
		if ($asset) {
			return $asset;
		}
	}
	
	function find_tags() {
		global $connection;
		$query  = "SELECT * FROM ";
		$query .= "tags";
		$tag_set = mysqli_query($connection, $query);
		confirm_query($tag_set);
		if ($tag_set) {
			return $tag_set;
		}
	}

	function add_points($user_id, $i) {
		global $connection;
		$query  = "UPDATE users ";
		$query .= "SET ";
		$query .= "points = ";
		$query .= " points + {$i} ";
		$query .= "WHERE id = {$user_id} " ;
		$result = mysqli_query($connection, $query);
		echo $query;
		confirm_query($result);
	}
	
	function check_confirmation($safe_user_id, $safe_source_user_id, $safe_game_id) {
		global $connection;
		$query = "SELECT * FROM completion_commits ";
		$query .= "WHERE user_id = {$safe_user_id} " ;
		$query .= "AND game_id = {$safe_game_id} ";
		$query .= "AND source_user_id = {$safe_source_user_id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		if ($result && mysqli_affected_rows($connection) >= 0) {
			$result_set = mysqli_fetch_assoc($result);
			$conf_check = $result_set["confirmed"];
			return $conf_check;
		}	else {
			return null;
		}
	}
	
	//LIST MODIFY FUNCTIONS
	
	function add_game_to_list($connection, $title, $platform, $challenge = "") {
		$required_fields = array("title", "platform");
		validate_presences($required_fields);
	
		$fields_with_max_lengths = array("title" => 40, "challenge" => 20);
		validate_max_lengths($fields_with_max_lengths);
	
		$game = find_game_by_title($_POST["title"]);
		$title = mysql_prep($_POST["title"]); // Use the user-submitted title
		$platform = mysql_prep($_POST["platform"]); // Use the user-submitted platform
		$challenge = mysql_prep($_POST["challenge"]);
	
		// Inserts game data into user's list, returns existing id if game already exists
		if (empty($errors)) {
			// Makes sure the game has not been entered already. This does not check for misspellings. It only checks the string as provided by the user.
				$query  = "INSERT INTO games ("; 
				$query .= " title, platform";
				$query .= ") VALUES (";
				$query .= " '{$title}', '{$platform}' ";
				$query .= ")";
				$result = mysqli_query($connection, $query); 
		
				if ($result && mysqli_affected_rows($connection) >= 0) {
					//Success
					$safe_title = htmlspecialchars($title);
					$_SESSION["message"] = "{$safe_title} added to database. "; 
				} else {
					//Failure
					$_SESSION["message1"] = "Game Already Entered into database. ";
				}
			// Inserts into relational table. This identifies the game with the user.	
			// Once again, game is the only table that uses the syntax game_id.
			$game = find_game_by_title($_POST["title"]);
			$user_id = mysql_prep($_SESSION["user_id"]);
			$game_id = mysql_prep($game["game_id"]);

			$query  = "INSERT IGNORE INTO users_games ("; 
			$query .= " user_id, game_id, challenge";
			$query .= ") VALUES (";
			$query .= " {$user_id}, {$game_id}, '{$challenge}' ";
			$query .= ")";
			$result = mysqli_query($connection, $query); 
			//$result will not be a typical variable. It will be a resource.

			if ($result && mysqli_affected_rows($connection) >= 0) {
				//Successs
				$_SESSION["message"] .= "<br />Your list has been updated.";
				redirect_to("add_game.php");
			} else {
				//Failure
				$_SESSION["message"] .= "Game Not Entered. Please contact the webmaster for help";
				redirect_to("add_game.php");
		  } 
		}
		
	}

	function leaderBoard($connection) {
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
	}
	
	
	//EXTERNAL API AND EMAIL FUNCTIONS
	
	function igdb_by_title($title) {
		$url  = "https://www.igdb.com/api/v1/games";
		$url .= "/search";
		$url .= "?q=". urlencode(ucwords($title));
		$url .= "";

		$curl = curl_init($url);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','Authorization: Token token=U3GrGcIV2I75dxfumnCpcPDzjyK_NiSqsiuPBINaeh0'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		curl_close($curl);

		//CONVERTS THE JSON ARRAY

			$game_set = json_decode($result, true);
		//GRABS THE ID 
			$game_id = $game_set["games"][0]["id"];
	
		//CALLS FOR ALL DATA USING THE ID
		$url  = "https://www.igdb.com/api/v1/games/";
		$url .= "/{$game_id}";
		$url .= "";
		$url .= "";

		$curl = curl_init($url);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','Authorization: Token token=U3GrGcIV2I75dxfumnCpcPDzjyK_NiSqsiuPBINaeh0'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		curl_close($curl);
		//converts the json array

		$game_set = json_decode($result, true); 
		return $game_set;
	}
	
	function send_email($subject, $body, $recipient) {

		include_once("PHPMailer/PHPMailerAutoload.php");

		$mail = new PHPMailer;
		
		$mail->SMTPDebug = 1;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'secure30.rvgsymphony.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'quest@rvgsymphony.com';                 // SMTP username
		$mail->Password = 'Koj1is#1';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465; 
		                                  // TCP port to connect to
		$mail ->isSendmail();                               //Enables Sendmail

		$mail->setFrom('quest@rvgsymphony.com', 'The Quest');
		$mail->addAddress($recipient);     // Add a recipient
		// $mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo('quest@rvgsymphony.com', 'The Quest');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = "<img src=\"http://www.rvgsymphony.com/quest/public/images/quest_logo.png\"></img><br />". $body;
		$mail->AltBody = $body;

		if(!$mail->send()) {
		    $_SESSION["message"] .= "Message might not appear in the user's inbox. ";
		   // $_SESSION["message"] .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
		    $_SESSION["message"] .= "Message has been sent. ";
		}
	}

	
	//PASSWORD AND LOGIN FUNCTIONS //
	
	function password_encrypt($password) {
		$hash_format = "$2y$10$"; //encrypts using blowfish with a cost of 10
		$salt_length = 22; //Blowfish salts will be 22 characters or more
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	function generate_salt($length) {
		$unique_random_string = md5(uniqid(mt_rand(), true));
		
		//ensures valid characters for a salt
		$base64_string = base64_encode($unique_random_string);
		$modified_base64_string = str_replace('+', '.', $base64_string);
		
		// Then truncate the string to the correct length
		$salt = substr($modified_base64_string, 0, $length);
		
		return $salt;
	}
	
	function password_check($password, $existing_hash) {
		$hash = crypt($password, $existing_hash);
		if ($hash === $existing_hash) {
			return true;
		} else {
			return false;
		}
	}
	
	function attempt_login($username, $password) {
		$user = find_user_by_username($username);
			if ($user) {
				if (password_check($password, $user["hashed_password"])) {		
				//password matches
				return $user;
				} else {
					//password does not match
					return false;
				}
			} else {
				// admin not found
				$error[] = "username not found. :/";
				return false;
			}		
	}
	
	function logged_in() {
		return isset($_SESSION["user_id"]);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("index.php");
		}		
	}
?>