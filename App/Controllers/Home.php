<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 16:28
 */
namespace App\Controllers;

use \Core\View;
use Token;

class Home extends \Core\Controller
{
    /**
     * method for the landing page
     * @return void
     */
    public function indexAction()
    {

        View::renderTemplate('Home/index.php', [
            'name'      => 'Dear Customer',
            'colours'   => ['red', 'green', 'brown']
        ]);
    }


    /**
     * Method to load the form page
     * @return void
     */
    public function registerAction()
    {
        $token = Token::generate();

        View::renderTemplate('Home/register.php', [
            'token'      => $token
        ]);
    }
}