<?php
declare(strict_types = 1);

class Authenticator {

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->errors = array();
    }

    public static function passwordCheck($password, $existing_hash) {
            $hash = crypt($password, $existing_hash);
            if ($hash === $existing_hash) {
                return true;
            } else {
                return false;
            }
        }
        
    public function attemptLogin(string $username, string $password) 
    {
        $user = find_user_by_username($username);
            if ($user && password_check($password, $user["hashed_password"])) {		
                //password matches
                return $user;
            } else {
                $this->errors[] = "The username and password pair was not found";
                return false;
            }		
    }

    private function find_user_by_username(string $username)
    {
		
		$safe_user = mysqli_real_escape_string($this->connection, $username);

		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE username = '{$safe_user}' ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($this->connection, $query);
		confirm_query($user_set);	
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}
    
    public static function loggedIn() {
        return isset($_SESSION["user_id"]);
    }
    
    public static function confirmLoggedIn() {
        if (!logged_in()) {
            redirect_to("index.php");
        }		
    }
}
?>