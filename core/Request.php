<?php
namespace app\core;

class Request{

    protected static $csrfKey = "_csrf";

    public static function isPost($checkCsrf = true){
        if($_SERVER['REQUEST_METHOD'] != "POST"){
            return false;
        }

        if($checkCsrf){
            return self::checkCsrf();
        }

        return true;
    }

    public static function isAjax(){
        return;
    }

    public static function post($key = null){
        if(!$key){
            return $_POST;
        }

        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    public static function get($key = null){
        if(!$key){
            return $_GET;
        }

        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    public static function request($key = null){
        if(!$key){
            return $_REQUEST;
        }

        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
    }

    public static function only($data, $keys = []){
        $request = [];

        foreach ($keys as $key){
            if(isset($data[$key])){
                $request[$key] = $data[$key];
            }
        }

        return $request;
    }

    public static function checkCsrf($token = null){

        if(!$token){
            $token = self::post(self::$csrfKey);
        }

        return self::csrf() == $token;
    }

    public static function csrf(){
        return crypt($_SERVER['HTTP_USER_AGENT'].":".$_SERVER['REMOTE_ADDR'], "qwerty");
    }

    public static function getUniqueTokenUser(){
        return static::csrf();
    }
}