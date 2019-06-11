<?php
namespace app\core\cache;

interface CacheInterface{


    public function get($key);

    public function set($key, $value);
}