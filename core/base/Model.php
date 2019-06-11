<?php
namespace app\core\base;

use app\core\additionals\Validator;

class Model{
    public   $errors = [];

    public function validate($data, $scenario){
        $rules = static::validatorRules();
        if(!isset($rules[$scenario])){
            return false;
        }

        $validator = new Validator($data, $rules[$scenario]);
        $checkedData = $validator->check();


        if($validator->errors){
            $this->errors = $validator->errors;
            return false;
        }
        return $checkedData;
    }

    protected static function validatorRules(){
        return [

        ];
    }
}