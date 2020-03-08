<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/app/functions.php";

use ITTech\APP\Main;
use ITTech\Lib\Route;
use ITTech\APP\Request;

/*
 * Подключить API
 */
if(Request::segment(1) == "api")
{
    require_once __DIR__."/app/APIController.php";
    $api = new \ITTech\APP\APIController();
    $api->init();
    exit();
}

$main = new Main(__DIR__);

/*
 * Загрузить модули, плагины
 */
$main->modules()->plugins();

/*
 * Маршрутизация
 */
$route = Route::get();
if(!$route)
{
    $main->notFound();
    exit();
}

$controller = new $route["controller"]();
$method     = $route["method"];

$controller->$method();

