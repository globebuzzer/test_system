<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 20:55
 */
class Session
{

    public static function exists($name){
        return (isset($_SESSION[$name]))? true: false;
    }

    public static function put($name, $value){
        return $_SESSION[$name] = $value;
    }

    public static function get_session($name){
        return $_SESSION[$name];
    }

    public static function delete($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }
    }

    public static function flash($name, $message = ''){
        if(self::exists($name)){
            $session = self::get_session($name);
            self::delete($name);
            return $session;
        }else{
            self::put($name, $message);
        }
    }

}