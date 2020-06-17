<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 01:02
 */
namespace App;

/**
 * Configuration file
 */
class Config
{
    /**
     * Database host
     * @var string
     */
    const DB_HOST = '127.0.0.1';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'password';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'test_system';


    /**
     * Show or hide error message on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;

    //private $GLOBALS = [];

    public function __construct()
    {

    }


    /**
     * Method to get database connection details
     * Cookie and session details
     * @return array
     */
    public static function getGlobals()
    {
        $GLOBALS['config'] = [
            'mysql'     => [
                'host'      => self::DB_HOST,
                'username'  => self::DB_USER,
                'password'  => self::DB_PASSWORD,
                'db'        => self::DB_NAME
            ],
            'remember' => [
                'cookie_name'   => 'hash',
                'cookie_expiry' => 604800
            ],
            'session' => [
                'session_name'  => 'user',
                'token_name'    => 'token'
            ]
        ];
        return $GLOBALS['config'];
    }

    /**
     * Method to get database connection details
     * Cookie and session details
     * @param null $paths
     * @return array|bool|mixed
     */
    public static function get_config($paths = null)
    {
        if($paths){
            $config = self::getGlobals();
            $connect = explode('/', $paths);

            foreach ($connect as $path){
                if(isset($config[$path])){
                    $config = $config[$path];
                }
            }
            return $config;
        }
        return false;
    }
}