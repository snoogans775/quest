<?php
namespace Quest;

class Session 
{
	public function __construct()
	{
		session_start();
	}
	
	public function message() {
		if(isset($_SESSION["message"])) {
		$output  = "<div class=\"message\">";
		$output .= htmlentities($_SESSION["message"]);
		$output .= "</div>";
		
		$_SESSION["message"] = null;
		
		return $output;
	  }
	}
	
	public function errors() {
		if(isset($_SESSION["errors"])) {
			$errors = $_SESSION["errors"];
			
			$_SESSION["errors"] = null;
			return $errors;
		}
	}
}
?>