<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 06/08/19
 * Time: 10:53
 */
class Hash {

    public static function make($string, $salt=''){
        return hash('sha256', $string.$salt);
    }

    public static function salt($length){
        return random_bytes($length);
    }

    public static function  unique(){
        return self::make(uniqid());
    }

    public static function generate_key(){
        return base64_encode(openssl_random_pseudo_bytes(32));
    }

    public static function encrypt($data, $key){
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }

    public static function decrypt($data, $key){
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

}