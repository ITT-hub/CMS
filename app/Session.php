<?php
/*
 * Created 30.12.2019 13:26
 */

namespace ITTech\APP;

/**
 * Class Session
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Регистрация сессии
     * @param string $sessionKey
     * @param mixed $sessionValue
     * @return bool
     */
    protected function session_create(string $sessionKey, $sessionValue): bool
    {
        if($_SESSION[$sessionKey] = $sessionValue)
        {
            return true;
        }
        return false;
    }

    /**
     * Возврат сессии
     * @param string $sessionKey
     * @return bool|mixed
     */
    protected function session_get(string $sessionKey)
    {
        if(!empty($_SESSION[$sessionKey]))
        {
            return $_SESSION[$sessionKey];
        }

        return false;
    }

    /**
     * Создать сессию
     * @param string $sessionKey
     * @param $sessionValue
     * @return bool
     */
    public static function set(string $sessionKey, $sessionValue)
    {
        $session = new self();
        return $session->session_create($sessionKey, $sessionValue);
    }

    /**
     * Выбрать сессию
     * @param string $sessionKey
     * @return bool|mixed
     */
    public static function get(string $sessionKey)
    {
        $session = new self();
        return $session->session_get($sessionKey);
    }
}
