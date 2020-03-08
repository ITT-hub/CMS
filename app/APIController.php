<?php
/*
 * Created 08.03.2020 8:44
 */

namespace ITTech\APP;

/**
 * Class APIController
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class APIController
{
    private $token;

    public function __construct()
    {

    }

    /**
     * Маршрутизировать методы запроса
     */
    public function init()
    {
        if($_SERVER["REQUEST_METHOD"] == "post")
        {
            return $this->postMethod();
        }

        return $this->getMethod();
    }

    /**
     * Входящие данные методом GET
     */
    private function getMethod()
    {

    }

    /**
     * Входящие данные методом POST
     */
    private function postMethod()
    {

    }
}