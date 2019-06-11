<?php
namespace app\core;

class Application{

    public static function start($data, $key = "action"){
        ob_start();
        $route = new \app\core\Route($data, $key);
        return $route->toRoute();
    }
}