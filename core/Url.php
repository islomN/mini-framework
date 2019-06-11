<?php
namespace app\core;

class Url{

    public static function current(){
        return $_SERVER['REQUEST_URI'];
    }

    public static function to($action){
        return "index.php?action=".$action;
    }

    public static function gotHome(){
        static::redirect();
    }

    public static function redirect($url = null){
        header("Location: http://".$_SERVER['HTTP_HOST']."/".$url);
        exit;
    }

    public static function paginationUrl($url, $key, $value){
        $reg = "/".$key."=-?\d+/uim";
        if(preg_match($reg, $url)){
            return preg_replace($reg, $key."=".$value, $url);
        }
        $prefix = "?";

        if(preg_match("/\?\w/", $url)){

            $prefix = "&";
        }

        return $url . $prefix.$key."=".$value;

    }
}