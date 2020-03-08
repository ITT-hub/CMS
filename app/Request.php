<?php
/*
 * Created 17.12.2019 11:54
 */

namespace ITTech\APP;

use ITTech\Lib\Cache;

/**
 * Class Request
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Request
{
    public function __construct()
    {
    }

    /**
     * Чтение директории
     * @param string $dir
     * @return array
     */
    public static function dir(string $dir): array
    {
        $scan = scandir($dir);
        unset($scan[0]);
        unset($scan[1]);
        sort($scan);

        for ($i=0; $i<count($scan); $i++)
        {
            if(is_dir($dir."/".$scan[$i]))
            {
                $data["path"][] = $scan[$i];
            } else {
                $data["file"][] = $scan[$i];
            }
        }

        return $data;
    }

    /**
     * Проверить кэш запроса
     */
    public static function checkCache()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(empty($_POST["_cache_"]))
            {
                exit("Отсутствует параметр POST запроса");
            }

            $cache = Main::$root."/tmp/cache/".$_POST["_cache_"];

            if(!file_exists($cache))
            {
                exit("Не верный хэш запроса");
            }

            ob_start();
            include $cache;
            $str = ob_get_contents();
            ob_end_clean();

            $unser = unserialize($str);
            if($unser["time"] <= time())
            {
                exit("Просрочен хэш запроса");
            }

            if($unser["ip"] != $_SERVER["REMOTE_ADDR"])
            {
                exit("Не верный адрес пользователя");
            }
        }
    }

    /**
     * Вернуть файл шаблона
     * @param string $templateFile
     * @return false|string
     */
    public static function getTemplate(string $templateFile)
    {
        ob_start();
        include $templateFile;
        $str = ob_get_contents();
        ob_end_clean();

        return $str;
    }

    /**
     * Выбор сегмента URL
     * @param int $segment
     * @return |null
     */
    public static function segment(int $segment)
    {
        $data = explode("/", $_SERVER["REQUEST_URI"]);
        if(!empty($data[$segment]))
        {
            return $data[$segment];
        }

        return null;
    }
}
