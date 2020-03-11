<?php
/*
 * Created 17.12.2019 10:58
 */

namespace ITTech\Modules\User;

use ITTech\APP\Controller;
use ITTech\APP\Main;
use ITTech\APP\Options;
use ITTech\APP\Redirect;
use ITTech\APP\Render;
use ITTech\APP\Session;
use ITTech\ORM\Connect;

/**
 * Class Auth
 * @package ITTech\Modules\User
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Auth extends Controller
{
    private $user;

    public function __construct($userData = null)
    {
        parent::__construct();

        if(!is_null($userData))
        {
            $this->user = $userData;
        }
    }

    /**
     * Авторизация пользователя
     * Использовать при условии что пользователь прошел проверку по телефону
     * @param string $phone
     * @param string $password
     * @return int|Auth
     */
    public static function User(string $phone, string $password)
    {
        $model = UserModel::where("phone", $phone)->get();
        // Пользователь не зарегестрирован
        if(count($model) < 1)
        {
            return 401;
        }

        // Пользователь не активирован
        if($model[0]->phone_enable == 0)
        {
            return 402;
        }

        if(!password_verify($password, $model[0]->password))
        {
            return 403;
        }

        return  new self($model[0]);
    }

    public function getUser()
    {
        return $this->user;
    }
}
