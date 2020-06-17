<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 12:02
 */
namespace Core;
use PDO;
use App\Config;
class DB extends Model
{
    private static $_instance = null;

    protected $_tableName;
    protected $_pdo;
    private $_query;
    private $_error = false;
    private $_results;
    private $_data;
    private $_lastId;
    private $_count = 0;

    /**
     * DB constructor.
     */
    public function __construct()
    {
        try{
            // PDO(String, username, password)
            $this->_pdo = new PDO('mysql:host='.Config::get_config('mysql/host').';dbname='.Config::get_config('mysql/db'), Config::get_config('mysql/username') , Config::get_config('mysql/password'));

        }catch(PDOException $e){
            Redirect::to($e->getMessage(), 'error_connect_db.php');
        }
    }

    /**Method to get a db instance
     * @return DB|null
     */
    public static function getInstance()
    {
        // Following a singleton pattern
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    /**
     * Method to get the db object
     * @param $sql
     * @param array $params
     * @param null $xsl
     * @return $this
     */
    public function query($sql, $params = []){
        // pending
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }
            else{
                $this->_error = true;
            }
        }
        return $this;
    }

    /**
     * This method willbe used to run our query
     * @param $action
     * @param $table
     * @param array $where
     * @param null $xsl
     * @return $this|bool
     */
    public function action($action, $table, $where = []){
        if(count($where) === 3){
            $operators = ['=', '>', '<', '>=', '<='];
            $field      = $where[0];//username for example
            $operator   = $where[1];//equal
            $value      = $where[2];//louison
            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, [$value])->error()){
                    return $this;
                }
            }
        }
        return false;
    }

    /**
     * Method to select all data from a table
     * @param $table
     * @param $where
     * @return bool|DB
     */
    public function get($table, $where){
        return $this->action('SELECT *', $table, $where);
    }

    /*
     * Method to get all standard users
     * without their hashed password and salt
     * to allow json_encode to work properly
     * @param $table
     * @param $where
     * @return bool|DB
     */
    public function get_standard_user($table, $where){
        return $this->action('SELECT `id`, `username`, `name`, `joined`, `group`', $table, $where);
    }

    /**
     * Method to check if a single user object is found
     * @param $tablename
     * @param null $user
     * @return bool
     */
    public function findSingleUser($tablename, $user = null)
    {
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'username';
            //$tbl = $tablename;
            $obj = $this->get($tablename, [$field, '=', $user]);

            if($obj->_count){
                $this->_data = $obj->first();
                return true;
            }
        }
        return false;
    }

    /**
     * Method to delete record from a table
     * @param $table
     * @param array $where
     * @return bool|DB
     */
    public function delete($table, $where = []){
        return $this->action('DELETE', $table, $where);
    }

    /**
     * Method to count a particular set of columns.
     * @param type $table
     * @param type $where
     * @return bool|obj Object
     */
    public function count_selected_rows($table, $where = []){
        return $this->action('SELECT *', $table, $where);
    }

    /**
     * Method to insert record to a table
     * @param $table
     * @param array $fields
     * @return bool|string
     */
    public function insert($table, $fields = []){
        if(count($fields)){
            $keys   = array_keys($fields);
            $values = '';
            $x      = 1;
            foreach($fields as $field){
                $values .= '?';
                if($x < count($fields)){
                    $values .= ', ';
                }
                $x++;
            }
            $sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES ({$values})";
            if(!$this->query($sql, $fields)->error()){
                $this->_lastId = $this->_pdo->lastInsertId();
                return $this->_lastId;
            }
        }
        return false;
    }

    /**
     * Method to update table's record
     * @param $table
     * @param $id
     * @param $fields
     * @return bool
     */
    public function update($table, $id, $fields){
        $set = '';
        $x = 1;
        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if(!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;
    }

    /**
     * Will return the _error value
     * @return bool
     */
    public function error(){
        return $this->_error;
    }

    /**
     * This will return the count
     * @return int
     */
    public function count(){
        return $this->_count;
    }

    /**
     * Method to return the result set
     * @return mixed
     */
    public function results(){
        return $this->_results;
    }

    /**
     * This method is used to return the first
     * row of data
     * @return mixed
     */
    public function first(){
        return $this->results()[0];
    }

    /**
     * Method to return data
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Method to gegt the last insert Id
     * @return mixed
     */
    public function last_Id(){
        return $this->_lastId;
    }

    /**
     * This method is use for debugging purposes
     */
    public function pre(){
        echo '<pre>';
        var_dump($this);
        echo '</pre>';
    }

    /**
     * This methid is used for debugging purposes
     * It print out the object in a better readable way
     */
    public function simple(){
        echo '<pre>';
        print_r($this);
        echo '</pre>';
    }
}