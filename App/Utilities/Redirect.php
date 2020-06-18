<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 12:42
 */
class Redirect {

    public static function to($msg, $location = null){
        if($location){

            if(is_numeric($location)){
                switch($location){
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        //include 'errors/404.php';
                        exit();
                        break;
                }
            }
            header('Location: '.$location);
            exit();
        }
    }

}