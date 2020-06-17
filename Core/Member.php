<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 14:08
 */
namespace Core;
use Exception;
use ReflectionClass;

Class Member extends DB
{
    /**
     * Member constructor.
     */
    public function __construct()
    {
        $this->_tableName = strtolower($this->processTableName());
    }

    /**
     * Select all data in table
     * @return bool|DB
     */
    public function getAllData()
    {
        $result = static::getInstance()->get($this->_tableName, ['id', '>', 0]);
        return $result;
    }

    /**
     * This method will get ou the full object
     * @return mixed
     */
    public function getFullDataObject()
    {
        return static::getInstance()->results();
    }


    /**
     * Method to get a single table object
     * @param $tablename
     * @param array $field
     * @return bool|DB
     */
    public function getRecordField($tablename, $field = [])
    {
        $record = static::getInstance()->get($tablename, $field);
        return $record;
    }

    /**
     * Method to insert a data in the table
     * @param array $fields
     * @return bool|string
     */
    public function insertData($tablename, $fields = [])
    {
        if(!($obj = static::getInstance()->insert($tablename, $fields))){
            throw new \Exception('There was a problem inserting data to the DB');
        }else{
            return $obj;
        }
    }

    /**
     * Method to update
     * @param $tablename
     * @param $id
     * @param array $fields
     */
    public function updateData($tablename, $id, $fields = []){
        if(!static::getInstance()->update($tablename, $id, $fields)){
            throw new \Exception('There was a problem updating data');
        }else{
            return;
        }
    }

    /**
     * Method to find a single db object(row) if exist
     * based on field name or field id
     * @param $tablename
     * @param null $user
     * @return bool
     */
    public function findSingleData($tablename, $user = null)
    {
        return static::getInstance()->findSingleUser($tablename, $user);
    }

    /**
     * Method to get actual data from a single row
     * @return mixed
     */
    public function getSingleRecord()
    {
        return static::getInstance()->getData();
    }

    /**
     * Method to check if record is not empty
     * @return bool
     */
    public function exists(){
        return (!empty($this->getSingleRecord())) ? true : false;
    }

    /**
     * Method to find table name
     * @return string
     */
    protected function processTableName()
    {
        $reflect = new ReflectionClass($this);
        return $reflect->getShortName();
    }

    /**
     * Method to get the table name
     * @return string
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * Method to delete a row
     * @param $tablename
     * @param array $where
     * @return bool|DB
     */
    public function delete($tablename, $where = [])
    {
        return static::getInstance()->delete($tablename, $where);
    }

}