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

    /*
     * Регистрация сессии
     */
    protected function session_create(string $sessionKey, $sessionValue): bool
    {
        if($_SESSION[$sessionKey] = $sessionValue)
        {
            return true;
        }
        return false;
    }

    /*
     * Возврат сессии
     */
    protected function session_get(string $sessionKey)
    {
        if(!empty($_SESSION[$sessionKey]))
        {
            return $_SESSION[$sessionKey];
        }

        return false;
    }

    /*
     * Временная сессия
     */
    protected function session_flash(string $key, $value)
    {
        if(!is_null($value))
        {
            return $this->session_create($key, $value);
        }

        if($this->session_get($key))
        {
            $value = $this->session_get($key);
            $this->session_delete($key);
        }

        return $value;
    }

    /*
     * Удалить сессию
     */
    protected function session_delete(string $sessionKey): void
    {
        if(!empty($_SESSION[$sessionKey]))
        {
            unset($_SESSION[$sessionKey]);
        }
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

    /**
     * Создание, выбор временной сессии
     *
     * @param string $key
     * @param null $value
     * @return bool|mixed
     */
    public static function flash(string $key, $value = null)
    {
        $session = new self();
        return $session->session_flash($key, $value);
    }

    /**
     * Удалить сессию
     * @param string $sessionKey
     */
    public static function destroy(string $sessionKey)
    {
        $session = new self();
        return $session->session_delete($sessionKey);
    }
}
