<?php
/*
 * Created 17.12.2019 14:34
 */

namespace ITTech\APP;

/**
 * Class Render
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Render
{
    /**
     * Массив контента
     * @var array
     */
    private static $content = [];

    /**
     * Добавить заголовок
     * @param string $title
     */
    public static function title(string $title): void
    {
        self::$content["title"] = $title;
    }

    /**
     * Добавить описание
     * @param string $desc
     */
    public static function desc(string $desc): void
    {
        self::$content["description"] = $desc;
    }

    /**
     * Добавить контент
     * @param string $content
     */
    public static function content(string $content): void
    {
        if(empty(self::$content["content"]))
        {
            self::$content["content"] = [];
        }
        array_push(self::$content["content"], $content);
    }

    /**
     * Возврат контента
     * @return array
     */
    public static function get(): array
    {
        return self::$content;
    }
}