<?php
use Core\DB;

/**
 * Created by PhpStorm.
 * User: louison
 * Date: 12/08/19
 * Time: 12:48
 */
class Validation
{

    private $_passed = false,
        $_errors = array(),
        $_db     = null;


    /**
     * Validation constructor.
     */
    public function __construct(){
        $this->_db = DB::getInstance();
    }

    /**
     * This method is used to sanitise inputs
     * and validate them
     * @param $source
     * @param array $items
     * @return $this
     */
    public function check($source, $items = []){
        foreach($items as $item => $rules){
            foreach($rules as $rule => $rule_value){
                //$src = $source;
                $value = escape(trim($source[$item]));
                $elt = escape($item);

                if($rule === 'required' && empty($value)){
                    if($elt === 'dob'){
                        $elt =  'Date of birth';
                    }
                    elseif($elt === 'email'){
                        $elt =  'Your email';
                    }
                    $this->addError(ucfirst($elt), "is required.");
                }else if(!empty($value)){
                    switch($rule){
                        case 'min':
                            if(strlen($value) < $rule_value){
                                $this->addError(ucfirst($elt), "must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addError(ucfirst($elt), "should not exceed {$rule_value} characters.");
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rule_value]){
                                $this->addError(ucfirst($elt), "{$rule_value} must match.");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, [$item, '=', $value]);
                            if($check->count()){
                                $this->addError(ucfirst($elt), "already exists.");
                            }
                            break;
                    }
                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    /**
     * Collect all erros in the error array
     * @param $error
     * @param $message
     */
    private function addError($error, $message){
        $this->_errors[$error] = $message;
    }

    /**
     * This method returns the value of
     * the _passed value
     * @return bool
     */
    public function passed(){
        return $this->_passed;
    }

}