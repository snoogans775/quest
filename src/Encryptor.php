<?php

namespace quest\includes;

class Encryptor
{
    public function password_encrypt($password) {
            $hash_format = "$2y$10$"; //encrypts using blowfish with a cost of 10
            $salt_length = 22; //Blowfish salts will be 22 characters or more
            $salt = $this->generate_salt($salt_length);
            $format_and_salt = $hash_format . $salt;
            $hash = crypt($password, $format_and_salt);
            return $hash;
        }
        
    private function generate_salt($length) {
        $unique_random_string = md5(uniqid(mt_rand(), true));
        
        //ensures valid characters for a salt
        $base64_string = base64_encode($unique_random_string);
        $modified_base64_string = str_replace('+', '.', $base64_string);
        
        // Then truncate the string to the correct length
        $salt = substr($modified_base64_string, 0, $length);
        
        return $salt;
    }
}
?>