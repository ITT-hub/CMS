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
    /**
     * Версия API
     * @var string
     */
    private $ITTECH = "1.0";

    /**
     * json строка данные
     * @var string
     */
    private $_REQUEST;

    /**
     * APIController constructor.
     */
    public function __construct()
    {
        $version = null;
        if($_SERVER["REQUEST_METHOD"] == "GET")
        {
            $version        = $_GET["ITTECH"];
            $this->_REQUEST = $_GET;
        }
        else {
            $this->_REQUEST = file_get_contents('php://input');
            $post           = json_decode($this->_REQUEST);
            $version        = $post->ITTECH;
        }

        if($version != $this->ITTECH)
        {
            $data = json_decode($this->_REQUEST, true);
            $queryData = [
                "ID"       => $data["ID"],
                "Status"   => "Error",
                "dateTime" => strtotime(date("d.m.Y H:i:s")),
                "code"     => 400,
                "message"  => "API Version Mismatch"
            ];
            exit(json_encode($queryData));
        }
    }

    /**
     * Маршрутизировать методы запроса
     */
    public function init()
    {
        try {
            $request = json_decode($this->_REQUEST, true);
            header('Content-Type: application/json; charset=UTF-8');
            $methodData = explode(".", $request["Method"]);

            // проверить и подключить класс
            $this->includeFile($methodData[0]);
            $class      = "ITTech\\APP\\api\\".$methodData[0];
            $method     = $methodData[1];
            $controller = new $class();

            // Проверить наличие метода
            if(!method_exists($controller, $method))
            {
                $queryData = [
                    "ID"       => $request["ID"],
                    "Status"   => "Error",
                    "dateTime" => strtotime(date("d.m.Y H:i:s")),
                    "code"     => 404,
                    "message"  => "Method '".$method."' does not exist"
                ];
                exit(json_encode($queryData));
            }

            if(!empty($request["params"]))
            {
                $result = $controller->$method($request["params"]);
            }
            else
            {
                $result = $controller->$method();
            }

            $queryData = [
                "ID"       => $request["ID"],
                "Status"   => $result["status"],
                "dateTime" => strtotime(date("d.m.Y H:i:s"))
            ];

            if($result["status"] == "Error")
            {
                $queryData["code"]    = $result["code"];
                $queryData["message"] = $result["message"];
            }
            else
            {
                $queryData["result"] = $result["result"];
            }

        } catch (\ErrorException $e)
        {
            $queryData = [
                "ID"       => $request["ID"],
                "Status"   => $result["status"],
                "dateTime" => strtotime(date("d.m.Y H:i:s")),
                "code"     => $e->getCode(),
                "message"  => $e->getMessage()
            ];
        }

        echo json_encode($queryData);
        exit();
    }

    /**
     * Подключить вызываемый класс
     * @param string $file
     */
    private function includeFile(string $file)
    {
        $request = json_decode($this->_REQUEST, true);
        if(!is_file(__DIR__."/api/".$file.".php"))
        {
            $queryData = [
                "ID"       => $request["ID"],
                "Status"   => "Error",
                "dateTime" => strtotime(date("d.m.Y H:i:s")),
                "code"     => 404,
                "message"  => "Method '".$file."' does not exist"
            ];
            exit(json_encode($queryData));
        }

        require_once __DIR__."/api/".$file.".php";
    }
}
