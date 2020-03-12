<?php
/*
 * Created 11.03.2020 12:43
 */

namespace ITTech\APP\api;

use ITTech\APP\ApiTemplateController;
use ITTech\Modules\User\UserModel;

/**
 * Class Auth
 * @package ITTech\APP\api
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Auth extends ApiTemplateController
{
    /**
     * Время действия токена сек.
     * @var int 7 дней 604800
     */
    protected $remember_time‬;

    public function __construct()
    {
        parent::__construct();
        $this->remember_time‬ = 3600;
    }

    /**
     * Авторизация пользователя
     * @param array $loginData
     * @return array
     */
    public function Login(array $loginData): array
    {
        $model = UserModel::where("phone", $loginData["username"])->get();

        // Авторизация по СМС
        if(!empty($loginData["sms"]))
        {
            if($loginData["server"] != $loginData["сlient"])
            {
                return ["status" => "Error", "code" => 405, "message" => "Verification code does not match"];
            }

            // Пользователя нет в системе
            if(count($model) < 1)
            {
               $model[0]               = new UserModel();
               $model[0]->phone        = $loginData["username"];
               $model[0]->phone_enable = 1;

               $save = $model[0]->save();

               if($save)
               {
                   $model = UserModel::where("id", $save)->get();
                   return $this->user($model);
               }

               return ["status" => "Error", "code" => 407, "message" => "Failed to create user"];
            }

            return $this->user($model);
        }

        // Пользователь не существует
        if(count($model) < 1)
        {
            return["status" => "Error", "code" => 408, "message" => "User does not exist"];
        }

        // Пользователь не активирован
        if($model[0]->phone_enable == 0)
        {
            return["status" => "Error", "code" => 401, "message" => "User not activated"];
        }

        // Пароль не верный
        if(!password_verify($loginData["password"], $model[0]->password))
        {
            return["status" => "Error", "code" => 402, "message" => "Password entered incorrectly"];
        }

        return $this->user($model);
    }

    /**
     * Авторизировать пользователя
     * @param UserModel $model
     * @return array
     */
    protected function user($model): array
    {
        $token             = bin2hex(openssl_random_pseudo_bytes(40));
        $model[0]->token   = $token;
        $model[0]->updated = date("Y-m-d H:i:s");

        if($model[0]->save())
        {
            return ["status" => "Ok", "result" => ["token" => $token]];
        }

        return ["status" => "Error", "code" => 406, "message" => "Token Write Error"];
    }

    /**
     * Проверка токена пользователя
     * @param array $params
     * @return array
     */
    public function check(array $params): array
    {
        try
        {
            $model = UserModel::where("token", $params["token"])->get();

            if(count($model) < 1)
            {
                return["status" => "Error", "code" => 403, "message" => "Record not found"];
            }

            $date     = strtotime(date("Y-m-d H.i.s"));
            $userDate = strtotime($model[0]->updated);
            $remember = $date - $userDate;

            if($remember >= $this->remember_time‬)
            {
                // авторизировать
                return["status" => "Error", "code" => 403, "message" => "Нужна авторизация"];
            }

            unset($model[0]->password);
            unset($model[0]->token);
            return["status" => "Ok", "result" => ["user" => $model[0]]];
        } catch (\ErrorException $e)
        {
            return["status" => "Error", "code" => $e->getCode(), "message" => $e->getMessage()];
        }
    }
}
