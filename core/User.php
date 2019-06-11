<?php
namespace app\core;

class User{

    protected static $sessKey = "user";

    private static $salt = "qwerty";
    public static function isAuth(){
        if(isset($_COOKIE[static::$sessKey])){
            $_SESSION[static::$sessKey] = unserialize($_COOKIE[static::$sessKey]);
        }

        if(!isset($_SESSION[static::$sessKey], $_SESSION[static::$sessKey]['id'], $_SESSION[static::$sessKey]['token'])){
            return false;
        }

        if($_SESSION[static::$sessKey]['token'] != Request::getUniqueTokenUser()){
            return false;
        }

        return \app\models\User::get($_SESSION[static::$sessKey]['id']);
    }

    public static function login($data){
        if(!isset($data['login']) || !isset($data['password'])){
            return false;
        }

        $user = \app\models\User::getByLogin($data['login']);
        if(!$user){
            return false;
        }

        $password = static::generatePassword($data['password']);
        if($password != $user['password']){
            return false;
        }

        $_SESSION[static::$sessKey] = ['id' => $user['id'], 'token' => Request::getUniqueTokenUser()];
        setcookie(static::$sessKey, serialize($_SESSION[static::$sessKey]), time()+3600*7);

        return true;
    }

    public static function logout(){
        unset($_SESSION[static::$sessKey]);
        setcookie(static::$sessKey, null, time()-1);
    }

    public static function register(){

    }


    public static function generatePassword($password){
        return crypt(md5($password), static::$salt);
    }
}