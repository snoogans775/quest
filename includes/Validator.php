<?php 
declare(strict_types = 1);

class Validator
{
    public function __construct() { 
        $this->postData = null;       
        $this->errors = array(); 
        $this->required_fields = array("username", "password");
        $this->fields_with_max_lengths = array("username" => 30);
    }

    // Conversion

    public function fieldname_as_text(String $fieldname) {
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    }
            
    // Presence

    public function has_presence(String $value) {
        return isset($value) && $value !== "";
    }

    public function validate_presences() {
        foreach($this->required_fields as $field) {
            $value = trim($this->postData[$field]);
            if (!$this->has_presence($value)) {
                $this->errors[$field] = $this->fieldname_as_text($field) . " can't be blank.";
            }
        }
    }

    //String Length
    public function has_max_length(string $value, int $max) {
        return strlen($value) <= $max;
    }

    public function validate_max_lengths() {
        // Expects an assoc. array
        foreach($this->fields_with_max_lengths as $field => $max) {
            $value = trim($this->postData[$field]);
            if (!$this->has_max_length($value, $max)) {
                $this->errors[$field] = $this->fieldname_as_text($field) . "is too long.";
            }
        }
    }

    // String type

    public function validate_email() {
        // Expects a string
            $value = trim($this->postData['email']);
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = $this->fieldname_as_text($value) . "is not a valid email address.";
            }
    }
    //Matching values
    public function match_passwords(string $pass, string $pass_confirm) {
        if ($this->postData[$pass] !== $this->postData[$pass_confirm]) {
            $this->errors[] = "Passwords are not the same.";
        }
    }

    //Inclusion in a set
    public function has_inclusion_in(string $value, array $set) {
        return in_array($value, $set);
    }

    //Format errors
    /** 
    * Convert eror array to renderable HTML Node
    * @param Array $errors
    * @return DOMNode
    */
    public static function formatErrors(Array $errors) 
    {
        $dom = new DOMDocument();
        if( !empty($errors)) {
            $container = $dom->createElement('div');
            $container->setAttribute('class', 'error');

            $ul = $dom->createElement('ul');
            foreach( $errors as $key=>$err) {
                $content = htmlentities($err);
                $li = $dom->createElement('li', $content);
                $ul->appendChild($li);
            }

            $container->appendChild($ul);
        }

        return $container;
	}

    //Getters and Setters
    public function getErrors() {
        return $this->errors;
    }

    public function setPostData(array $post) {
        $this->postData = $post;
    }
}

?>