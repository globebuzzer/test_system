<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 06/08/19
 * Time: 10:53
 */
class Hash {

    /**
     * Hash the passed value
     * @param $string
     * @param string $salt
     * @return string
     */
    public static function make($string, $salt=''){
        return hash('sha256', $string.$salt);
    }

    /**
     * Create a salt
     * @param $length
     * @return string
     */
    public static function salt($length){
        return random_bytes($length);
    }

    /**
     * make unique value
     * @return string
     */
    public static function  unique(){
        return self::make(uniqid());
    }

    /**
     * Generate token key
     * @return string
     */
    public static function generate_key(){
        return base64_encode(openssl_random_pseudo_bytes(32));
    }

}