<?php
namespace app\core\traits;

trait Magic{
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __call($name, $arguments)
    {
        if(!method_exists($this, $name)){
            throw new \Exception("undefined method");
        }

    }
}