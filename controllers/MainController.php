<?php
namespace app\controllers;

use app\core\base\Controller;
use app\core\HttpErrors;
use app\core\Request;
use app\core\Response;
use app\core\User;
use app\models\Calc;
use app\models\CalcErrors;
use app\models\HystoryCalc;
use app\models\Tasks;

class MainController extends Controller  {

    public function actionIndex(){
	    return $this->render("main/index");
    }
}