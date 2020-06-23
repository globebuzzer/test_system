<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 19:35
 */
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined("PAGE_EXT") ? null : define("PAGE_EXT", '.html');

defined('SITE_ROOT') ? null : define('SITE_ROOT', realpath(dirname(__FILE__) . DS . ".." . DS));

defined('CLASSES_PATH') ? null : define('CLASSES_PATH', SITE_ROOT. DS . 'classes');


function escape($string){
    return strip_tags($string);
}