<?php
namespace app\core;

class HttpErrors{

    public static function badRequest(){
        self::getHeader(400, "Bad Request");
    }

    public static function notFound(){
        self::getHeader(404, "Not found");

    }

    public static function forbidden(){
        self::getHeader(403, "Forbidden");
    }

    public static function getHeader($code, $msg){
        header("HTTP/1.1 {$code} {$msg}");
        exit;
    }


}