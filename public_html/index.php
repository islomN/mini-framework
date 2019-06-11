<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
define("APP_DIR", __DIR__."/../");

require "../autoload.php";
require APP_DIR."/config/functions.php";

echo \app\core\Application::start($_GET, "action");
