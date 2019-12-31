<?php
/*
 * Created 17.12.2019 11:36
 */

namespace ITTech\APP;

/**
 * Class Main
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Main
{
    /**
     * Корневая директория
     * @var string
     */
    public static $root;

    /**
     * Main constructor.
     * @param string $root
     */
    public function __construct(string $root)
    {
        self::$root = $root;
        Request::checkCache();
    }

    /**
     * Загрузка плагинов
     * @return $this
     */
    public function plugins(): Main
    {
        return $this;
    }

    /**
     * Загрузка модулей
     * @return $this
     */
    public function modules(): Main
    {
        $scan = Request::dir(self::$root."/modules");

        if(!empty($scan["path"]))
        {
            foreach ($scan["path"] as $class)
            {
                $className = "\\ITTech\\Modules\\".$class."\\".$class;
                if (method_exists($className, "route"))
                {
                    $className::route();
                }
            }
        }

        if(!empty($scan["file"]))
        {
            foreach ($scan["file"] as $class)
            {
                $fileName  = substr($class, 0, -4);
                $className = "\\ITTech\\Modules\\".$fileName;
                if (method_exists($className, "route"))
                {
                    $className::route();
                }
            }
        }
        return $this;
    }

    public function notFound()
    {

    }
}
