<?php
namespace app\core;

class Route{

	private $data;
	public function __construct($data, $key){

		$this->data = isset($data[$key]) ? $data[$key] : null;
	}

	public function toRoute(){
        list($controllerName, $actionName) = $this->getNameList();

        if(!$actionName){
            $actionName = "index";
        }

        $controllerName = "\\app\\controllers\\".ucfirst($controllerName)."Controller";
        $controllerObj = new $controllerName;

        if(class_exists($controllerName)){
            return $controllerObj->action($actionName);
        }else{
            page404();
        }

	}

    public function getRoute(){

        if(!$this->data){
            $config = require APP_DIR . "/config/app.php";

            $this->data = $config['defaultRoute'];
        }

        return explode("/", $this->data);
    }

    private function getNameList(){
        $routes = $this->getRoute();
        $controllerName = null;
        $actionName = null;

        foreach($routes as $key => $route){

            if(!$routes[$key]) {
                unset($routes[$key]);
                continue;
            }
            if($controllerName){
                $actionName = $route;
            }

            if(!$controllerName){
                $controllerName = $route;
            }
        }

        return [$controllerName, $actionName];
    }

	
}