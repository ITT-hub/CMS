<?php
/*
 * Created 31.12.2019 13:40
 */

namespace ITTech\APP;

/**
 * Class Redirect
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Redirect
{
    /**
     * Переадресация на предыдущую страницу
     */
    public static function back(): void
    {
        header('Location: '.$_SERVER["HTTP_REFERER"]);
        exit;
    }
}