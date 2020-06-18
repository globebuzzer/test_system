<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 20:59
 */
class Input
{

    /**
     * Check if any input entered
     * @param string $type
     * @return bool
     */
    public static function exists($type = 'post'){
        switch($type){
            case 'post':
                return (!empty($_POST))? true: false;
                break;
            case 'get':
                return (!empty($_GET))? true: false;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Check entered input if valid
     * @param $item
     * @return string
     */
    public static function get_input($item){

        if(isset($_POST[$item])){
            return $_POST[$item];
        }elseif(isset($_GET[$item])){
            return $_GET[$item];
        }

        return '';
    }

    /**
     * Filter input to return those allowed
     * @param array $input
     * @return array
     */
    public static function get_allowed_input($input = []){
        $input_item = [];

        foreach($input as $item){
            if(self::get_input($item)){
                $input_item[$item] = self::get_input($item);
            }else{
                $input_item[$item] = NULL;
            }
        }
        return $input_item;
    }
}