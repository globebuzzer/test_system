<?php
/**
 * Created by PhpStorm.
 * User: louison
 * Date: 17/06/20
 * Time: 16:28
 */
namespace App\Controllers;

use \Core\View;
use App\Models\Customer;
use Token;
use Input;
use Validation;

class Home extends \Core\Controller
{
    /**
     * method for the landing page
     * @return void
     */
    public function indexAction()
    {
        //This a dummy page for test
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

    public function submitRegistrationAction()
    {
        $customer = new Customer();

        if (Token::check_token(Input::get_input('token'))) {
            $all_post = Input::get_allowed_input([
                'firstname', 'lastname', 'dob', 'email'
            ]);
            $validate = new Validation();
            $validation = $validate->check($all_post, [
                'firstname' => [
                    'required' => true,
                    'min' => 3,
                    'max' => 60
                ],
                'lastname' => [
                    'required' => true,
                    'min' => 3,
                    'max' => 60
                ],
                'dob' => [
                    'required' => true
                ],
                'email' => [
                    'required' => true
                ]
            ]);
            if ($validation->passed()) {
                Token::delete_token(Input::get_input('token'));
                try {
                    //save in the database
                    $lastId = $customer->insertData($customer->getTableName(), [
                        //db field       //posted allowed elements
                        'firstname'     => Input::get_input('firstname'),
                        'lastname'      => Input::get_input('lastname'),
                        'dateofbirth'   => Input::get_input('dob'),
                        'email'         => Input::get_input('email'),
                        'created'       => date("Y-m-d H:i:s")
                    ]);

                } catch (\Exception $e) {
                    //exceptioin handly here
                }
            }
        }
        else{
            /* Add Code tpo send user back to registration page with entered input
            and error message */
        }

    }
}