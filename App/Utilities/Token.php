<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 20:30
 */
use App\Config;
class Token {

    public static function generate(){
        return Session::put(Config::get_config('session/token_name'), md5(uniqid()));
    }

    public static function check_token($token){
        $tokenName = Config::get_config('session/token_name');

        if(Session::exists($tokenName) && $token === Session::get_session($tokenName)){
            return true;
        }

        return false;
    }

    public static function delete_token($token)
    {
        $tokenName = Config::get_config('session/token_name');
        if(Session::exists($tokenName) && $token === Session::get_session($tokenName)){
            Session::delete($tokenName);
        }
    }
}