<?php
namespace app\core\additionals;

use app\core\base\View;
use app\core\traits\Magic;
use app\core\traits\Singleton;

abstract class Widget{

    use Magic;
    use Singleton;

    protected static $namepath = "widgets";

    abstract public function run();

    public static function widget($args = []){
        $self = static::Instance();
        $self->init();

        if($args){
            foreach($args as $key => $value){
                $self->$key = $value;
            }
        }

        return $self->run();
    }

    protected function init(){

    }

    protected function render($view, $args = []){
        $viewObj = View::Instance();
        return $viewObj->render("_widgets/".$view, $args);
    }
}