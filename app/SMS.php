<?php
/*
 * Created 12.03.2020 13:10
 */

namespace ITTech\APP;

use ITTech\ORM\Connect;

require_once $_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php";

/**
 * Class SMS
 * Отправка СМС кода на телефон пользователя
 * @package ITTech\crm\Core
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class SMS
{
    /**
     * Ключ API
     * @var null
     */
    private $api_id = null;

    /**
     * Сервер отправки сообщения
     * @var string
     */
    private $serverURL = "https://sms.ru/sms/send";

    /**
     * Номер телефона получателя
     * @var string|null
     */
    private $number = null;

    /**
     * Сгенерированый код подтверждения
     * @var int
     */
    private $confirm = 0;

    public function __construct(string $number)
    {
        $iniFile = $_SERVER["DOCUMENT_ROOT"]."/_config.ini";
        $this->number = $number;
        $cfg = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/_config.ini");
        Connect::create($cfg);
        Connect::getInstance();
        $this->api_id = $cfg["api_key"];
    }

    /**
     * Инициализация класса
     * @param string $number
     * @return SMS
     */
    public static function create(string $number): self
    {
        return new self($number);
    }

    /**
     * Генерация кода авторизации
     * @return SMS
     */
    public function generate(): SMS
    {
        $this->confirm = mt_rand(00001, 99999);
        return $this;
    }

    /**
     * Отправить СМС
     * @return array|int
     */
    public function send()
    {
        $ch = curl_init($this->serverURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CAINFO, $_SERVER["DOCUMENT_ROOT"] . '/test/cacert.pem');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "api_id" => $this->api_id,
            "to" => $this->number,
            "msg" => $this->confirm,
            "json" => 1
        )));
        $result = curl_exec($ch);

        if(curl_error($ch)) {
            echo curl_error($ch);
        }

        curl_close($ch);

        if(!$result)
        {
            return $result;
        }

        $resultData = json_decode($result);

        // Ошибка в отправке на сервер
        if($resultData->status == "ERROR")
        {
            return["code", $resultData->status_code, "message" => "Request Execution Error"];
        }

        // Ошибка отправки на номер
        $phone = $this->number;
        if($resultData->sms->$phone->status == "ERROR")
        {
            return["code", $resultData->sms->$phone->status_code, "message" => $resultData->sms->$phone->status_text];
        }

        return $this->confirm;
    }
}
