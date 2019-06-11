<?php
namespace app\core\traits;

trait Singleton{
    protected static $instance = null;

    public static function Instance(){

        if(static::$instance == null){
            static::$instance = new static();
        }

        return static::$instance;
    }
}