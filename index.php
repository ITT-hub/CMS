<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/app/functions.php";

use ITTech\APP\Main;
use ITTech\Lib\Route;
use ITTech\APP\Request;

$main = new Main(__DIR__);

/*
 * Подключить API
 */
if(Request::segment(1) == "api")
{
    $api = new \ITTech\APP\APIController();
    $api->init();
    exit();
}

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

