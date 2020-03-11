<?php
/*
 * Created 11.03.2020 12:27
 */

namespace ITTech\APP;

use ITTech\ORM\Connect;

/**
 * Class ApiTemplateController
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
abstract class ApiTemplateController
{
    /**
     * Объект подключения к базе данных
     * @var \PDO|null
     */
    protected $connect;

    public function __construct()
    {
        $cfg = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/_config.ini");
        Connect::create($cfg);
        $this->connect = Connect::getInstance();
    }
}
