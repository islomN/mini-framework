<?php
spl_autoload_register(function($class){
	$classPath = str_replace("\\", "/", $class);
	$classPath = str_replace("app/", __DIR__."/", $classPath);

	require $classPath.".php";
});