<?php
/*
 * Created 11.01.2020 12:28
 */

namespace ITTech\APP;

/**
 * Class Convert
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Convert
{
    /**
     * Преобразовать кириллицу в латинницу
     *
     * @param string $char
     * @return string
     */
    public static function translit(string $char): string
    {
        $char = (string) $char;
        $char = strip_tags($char);
        $char = str_replace(array("\n", "\r"), " ", $char);
        $char = preg_replace("/\s+/", ' ', $char);
        $char = trim($char);
        $char = function_exists('mb_strtolower') ? mb_strtolower($char) : strtolower($char);
        $char = strtr($char, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $char = preg_replace("/[^0-9a-z-_ ]/i", "", $char);
        $char = str_replace(" ", "_", $char);

        return $char;
    }
}