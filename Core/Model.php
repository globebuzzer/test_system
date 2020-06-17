<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 11:55
 */
namespace Core;

use App\Config;
use PDO;
abstract class Model
{

    protected $data;


    /*abstract protected function enter_data($fields = array());

    abstract protected function find($member = null);

    abstract protected function update($fields = array(), $id = null);

    abstract protected function delete($fields = array());*/


    protected static function getDB()
    {
        static $db = null;

        if($db === null){

            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            //throw an exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        }
    }

}