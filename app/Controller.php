<?php
/*
 * Created 17.12.2019 14:28
 */

namespace ITTech\APP;

use ITTech\ORM\Connect;
use ITTech\View\View;

/**
 * Class Controller
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Controller
{
    public function __construct()
    {
        $ini = parse_ini_file(Main::$root."/_config.ini");
        Connect::create($ini);
    }

    /**
     * Вывод на экран страницы
     * @param string $file
     */
    protected function render(string $file)
    {
        if(Options::get("site_cache") > 0)
        {
            $cache = Options::get("site_cache");
        } else {
            $cache = null;
        }
        $view = new View(Main::$root."/templates/".Options::get("template"), $cache);

        echo $view->render($file, Render::get());
    }
}
