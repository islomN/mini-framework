<?php
namespace app\core;

class Assets{

    protected $key = "assets";
    public $css = [];
    public $js = [];

    protected $assets;
    protected  $assetKey;
    public function __construct($assetKey = "main")
    {
        $assets = require APP_DIR."/config/assets.php";
        if($assets[$assetKey]){
            $this->assets = $assets[$assetKey];
        }
    }

    public function css(){
        $pattern = "<link rel=\"stylesheet\" href=\"{url}\">";
        $items = $this->getItems($pattern, "css");
        return $items;
    }

    public function js(){
        $pattern = "<script src=\"{url}\"></script>";
        $items = $this->getItems($pattern, "js");

        return $items;
    }

    protected  function getItems($pattern, $key){
        if(!isset($this->assets[$key]))
            return false;

        $items = $this->assets[$key];
        $_items = "";
        foreach ($items as $item){
            $_items .= str_replace("{url}", $item,$pattern);
        }

        return $_items;
    }
}?>


