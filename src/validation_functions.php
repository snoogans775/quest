<?php 
		
$errors = array(); 

function fieldname_as_text($fieldname) {
	$fieldname = str_replace("_", " ", $fieldname);
	$fieldname = ucfirst($fieldname);
	return $fieldname;
}
		
// Presence

function has_presence($value) {
	return isset($value) && $value !== "";
}

function validate_presences($required_fields) {
	global $errors;
	foreach($required_fields as $field) {
		$value = trim($_POST[$field]);
		if (!has_presence($value)) {
			$errors[$field] = fieldname_as_text($field) . " can't be blank.";
		}
	}
}

//String Length
function has_max_length($value, $max) {
	return strlen($value <= $max);
}

function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
		if (!has_max_length($value, $max)) {
			$errors[$field] = fieldname_as_text($field) . "is too long.";
		}
	}
}

// String type

function validate_email($email) {
	global $errors;
	// Expects a string
		$value = trim($_POST[$email]);
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$errors[] = fieldname_as_text($value) . "is not a valid email address.";
		}
}
//Matching values
function match_passwords($pass, $pass_confirm) {
	global $errors;
	if ($_POST[$pass] !== $_POST[$pass_confirm]) {
		$errors[] = "Passwords are not the same.";
		return $errors;
	}
}

//Inclusion in a set
function has_inclusion_in($value, $set) {
	return in_array($value, $set);
}

// DATABASE CHECKS
function check_db_for_username($username) {
	global $errors;
	if (find_user_by_username($username)) {
		$errors[] = "That name is already taken. Bummer.";
	}
}

?>