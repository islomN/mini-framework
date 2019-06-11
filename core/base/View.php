<?php
namespace app\core\base;

use \app\core\traits\Magic;
use app\core\traits\Singleton;

class View{

    use Magic;
    use Singleton;
    public $title;
	public static $defaultDir = APP_DIR."/views";

    public function render($view, $args = []){
		ob_start();

		if($args){
			extract($args);
		}
		
		require self::$defaultDir."/".$view.".php";
		
		return ob_get_clean();
	}
}


