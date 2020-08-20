<?php

class Database 
{
	public function getConnection() 
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

	public function find_all_subjects($connection) {
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);	
		return $subject_set;
	}
}	
?>