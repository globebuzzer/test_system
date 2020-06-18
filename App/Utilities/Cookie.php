<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 06/08/19
 * Time: 10:48
 */
class Cookie {

    /**
     * Check if cookie exists
     * @param $name
     * @return bool
     */
    public static function exists($name){
        return (isset($_COOKIE[$name])) ? true : false;
    }

    /**
     * Get the cookie
     * @param $name
     * @return mixed
     */
    public static function get_cookie($name){
        return $_COOKIE[$name];
    }

    /**
     * Set the cookie
     * @param $name
     * @param $value
     * @param $expiry
     * @return bool
     */
    public static function put($name, $value, $expiry){
        if(setcookie($name, $value, time() + $expiry, '/')){
            return true;
        }

        return false;
    }

    /**
     * Delete the cookie
     * @param $name
     */
    public static function delete($name){
        self::put($name, '', time() - 1);
    }

}