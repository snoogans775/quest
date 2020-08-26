<?php
namespace Quest;

require_once('Validator.php');
require_once('Encryptor.php');
require_once('Controller.php');

class Database 
{
	public function __construct()
	{
		$this->connection = null;
		$this->errors = array();
	}

	static public function getConnection() 
	{

		define("DB_SERVER", "localhost");
		define("DB_USER", "quest_admin");
		define("DB_PASS", "Koj1is#1");
		define("DB_NAME", "quest");
		//creates a database connection
		$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		// tests connection for errors
		if(mysqli_connect_errno()) {
			die("Database connection failed: ".
						mysqli_connect_error() .
						" (" . mysqli_connect_errno() . ")"
			);
		}

		return $connection;
	}

	static public function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	static public function find_list_by_user($connection, $user_id) {
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
		self::confirm_query($game_set);
		
		return $game_set;
	}

	static public function find_all_subjects(object $connection) {
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		self::confirm_query($subject_set);	
		return $subject_set;
	}

	// USER FUNCTIONS //

	static public function find_all_users($connection) {
		$query = "SELECT * ";
		$query .= "FROM users ";
		$user_set = mysqli_query($connection, $query);
		self::confirm_query($user_set);	
		return $user_set;
	}
	
	static public function find_user_by_id($user_id) {
		global $connection;

		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE id = {$user_id} ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		self::confirm_query($user_set);	
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}
	
	static public function find_user_by_username($username) {
		global $connection;
		
		$safe_user = mysqli_real_escape_string($connection, $username);

		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE username = '{$safe_user}' ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		self::confirm_query($user_set);	
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}

	private function mysql_prep(object $connection, string $string) {
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}

	private function validate(array $postData)
	{
		$validator = new Validator();
		$validator->setPostData($postData);

		//validations
		$validator->validate_presences();	
		$validator->validate_max_lengths();
		$validator->validate_email();
		$validator->match_passwords("password", "password_confirm");

		$this->updateErrors($validator->getErrors());

	}

	private function insertUser(array $postData) 
	{
		$controller = new Controller();
		$encryptor = new Encryptor();
		$username = $this->mysql_prep($this->connection, $postData["username"]);
		$email = $this->mysql_prep($this->connection, $postData["email"]);
		$hashed_password = $encryptor->password_encrypt($_POST["password"]);

		//performs database query
		$query  = "INSERT INTO users ("; 
		$query .= " username, hashed_password, points, email, date_joined";
		$query .= ") VALUES (";
		$query .= " '{$username}', '{$hashed_password}', 400, '{$email}', NOW() ";
		$query .= ")";
		$result = mysqli_query($this->connection, $query); 
		
		//$result is a mysqli resource
		if ($result && mysqli_affected_rows($this->connection) >= 0) {
			//Success
			$_SESSION["message"] = "Account Created.";
			$controller::redirect('index.php');
		} else {
			//Failure
			$_SESSION["message"] = "Registration failed.";
			$controller::redirect("new_user.php");
		}
			
	}
	private function updateErrors(array $err) 
	{
		$this->errors = $err;
	}
	public function setDefaultConnection()
	{
		$this->connection = $this->getConnection();
	}
	public function addUser(array $postData)
	{
		$this->validate($postData);
		if( empty($this->errors) )
		{
			$this->insertUser($postData);
		}
	}
}	
?>