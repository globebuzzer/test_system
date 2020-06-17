<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 16/06/20
 * Time: 23:18
 */

session_start();
date_default_timezone_set('Europe/London');

/**
 * Twig autolaoder
 */
$twig_loader = __DIR__ . '/../vendor/autoload.php';
require_once $twig_loader;

require_once 'init.php';

/**
 * Error and Exceptionhandling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$router = new Core\Router();

//Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);

function err_log($message, $message_type = null, $destination = null, $extra_headers = null){
    error_log($message, $message_type, $destination, $extra_headers);
}