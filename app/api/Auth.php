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
     * Авторизация пользователя
     * @param array $loginData
     * @return array
     */
    public function Login(array $loginData)
    {
        $model = UserModel::where("phone", $loginData["username"])->get();

        // Пользователь не активирован
        if($model[0]->phone_enable == 0)
        {
            return["status" => "Error", "code" => 401, "message" => "User not activated"];
        }

        if(!password_verify($loginData["password"], $model[0]->password))
        {
            return["status" => "Error", "code" => 402, "message" => "Password entered incorrectly"];
        }

        $token = bin2hex(openssl_random_pseudo_bytes(40));
        $model[0]->token = $token;
        $model[0]->updated = date("Y-m-d H:i:s");
        $model[0]->save();

        return["status" => "Ok", "result" => ["token" => $token]];
    }

}
