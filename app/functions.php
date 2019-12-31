<?php

function getCache()
{
    $cachefile       = md5("form-".$_SERVER["REQUEST_URI"].time());
    $content["ip"]   = $_SERVER["REMOTE_ADDR"];
    $content["time"] = time() + time() + 180;

    if(is_writable(\ITTech\APP\Main::$root."/tmp/cache"))
    {
        if(file_put_contents(\ITTech\APP\Main::$root."/tmp/cache/".$cachefile, serialize($content)))
        {
           return $cachefile;
        }

        echo "Ошибка создания хэш";
    }

    echo "Директория ".\ITTech\APP\Main::$root."/tmp/cache не доступна";
}