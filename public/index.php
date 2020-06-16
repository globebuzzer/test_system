<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 16/06/20
 * Time: 23:18
 */


require_once 'init.php';

/**
 * Error and Exceptionhandling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');