<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/app/functions.php";

use ITTech\APP\Main;
use ITTech\Lib\Route;

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

