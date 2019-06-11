<?php
namespace app\core;

class Response{

    public static function jsonType($data){
        header("Content-Type: application/json");
        return json_encode($data);

    }
}