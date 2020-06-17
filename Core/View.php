<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 14:15
 */
namespace Core;
class View
{
    /**
     * Method to render a view
     * @param $view
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; //relative to Core directpry

        if(is_readable($file)){
            require $file;
        }else{
            throw new \Exception("$file not found");
        }
    }

    /**
     * @param $template
     * @param array $args
     */
    public static function renderTemplate($template, $args=[])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}