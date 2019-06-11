<?php

namespace app\core\base;

use app\core\magic\MagicController;

class Controller{


    protected $layout = "layouts/index";
    protected $title = "";


	public function action($name){
	    
	    $this->beforeAction($name);
		$action = "action".ucfirst($name);

        if(!method_exists($this, $action)){
            header("HTTP/1.1 404 Not found");
        }

		$res =  $this->$action();
        $this->afterAction();
        return $res;
	}

	public function beforeAction($action){

    }

    public function afterAction(){

    }

	protected function renderPartial($view, $args){
	    return $this->render($view, $args, false);
    }
	
	protected function render($view, $args = [], $layout = true){
		$viewObj = View::Instance();
        $content = $viewObj->render($view, $args);

        if($layout == false){
            return $content;
        }

        $viewObj->title = $this->title;

        return $viewObj->render($this->layout, ['content' => $content]);

	}
}