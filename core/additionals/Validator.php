<?php
namespace app\core\additionals;

class Validator{

    public $errors = [];
    protected $rules;
    public $data = [];

    public  function  __construct($data, $rules)
    {
        $this->rules = $rules;
        $this->data = $data;
    }

    public function check(){

        if(empty($this->rules)){
            return false;
        }

        $checkedData = [];
        foreach ($this->rules as $key => $rule){

            $items = explode(":", $rule);

            $res = $this->innerCheck($key, $items);
            if($res == -1){
                return false;
            }

            if(!isset($this->errors[$key]))
                $checkedData[$key] = isset($this->data[$key]) ? $this->data[$key] : null;
        }

        if($this->errors){
            return false;
        }

        return $checkedData;

    }

    protected  function innerCheck( $key, array $items){
        foreach($items as $item){

            if(isset($this->errors[$key])){
                continue;
            }

            $item = explode("=", $item);

            switch(count($item)){
                case 2:
                    list($method, $param) = $item;
                    break;
                case 1:
                    $param = null;
                    $method = $item[0];
                    break;
                default:
                    return -1;
            }

            $method = $method."Validator";

            if(!method_exists($this, $method)){
                return -1;
            }

            if(($error = $this->$method($key,$param)) !== true){
                $this->errors[$key] = $error;
            }
        }
    }

    protected static function getParams($params){

    }

    public function requiredValidator( $key){

        if(static::emptyData($this->data, $key)){
            return "Заполните поле";
        }

        return true;
    }

    public  function emailValidator($key){
        if(static::emptyData($this->data, $key)){
            return true;
        }

        if(filter_var($this->data[$key], FILTER_VALIDATE_EMAIL)){
            return true;
        }

        return "Неправильный E-mail ";
    }

    public  function stringValidator( $key){
        if(static::emptyData($this->data, $key)){
            return true;
        }

        if(!is_string($this->data[$key])){
            return "Это не строка";
        }

        return true;

    }

    public  function textValidator($key){
        if(static::emptyData($this->data, $key)){
            return true;
        }

        if(!is_string($this->data[$key])){
            return "Это не текст";
        }
        return true;
    }

    public function defaultValidator($key, $val){
        if(static::emptyData($this->data, $key)){
            $this->data[$key] = $val;

        }

        return true;
    }

    public function maxValidator($key, $len){
        if(static::emptyData($this->data, $key)){
            return true;
        }

        if(mb_strlen($this->data[$key]) >= $len){
            return "Максимальная длина ".$len;
        }

        return true;
    }

    public function minValidator($key, $len){
        if(static::emptyData($this->data, $key)){
            return true;
        }

        if (mb_strlen($this->data[$key]) <= $len) {
            return "Минимальная длина " . $len;
        }

        return true;
    }

    protected static function emptyData($data, $key){
        if(!isset($data[$key]) || empty($data[$key])){
            return true;
        }
    }

    public  function integerValidator($val){
        return is_integer($val);
    }

}