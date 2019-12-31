<?php
/*
 * Created 17.12.2019 10:58
 */

namespace ITTech\Modules\User;

use ITTech\APP\Controller;
use ITTech\APP\Main;
use ITTech\APP\Render;
use ITTech\APP\Session;

/**
 * Class Auth
 * @package ITTech\Modules\User
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Auth extends Controller
{
    /**
     * Проверить куки, авторизировать
     * @return bool
     */
    public function coocies()
    {
        if(empty($_COOKIE["user"]))
        {
            return false;
        }

        $file = Main::$root."/tmp/cache/".$_COOKIE["user"];
        if(file_exists($file))
        {
            ob_start();
            include $file;
            $data = unserialize(ob_get_contents());
            ob_end_clean();

            if($data["time"] <= time())
            {
                return false;
            }

            $user = UserModel::find($data["uid"]);

            if(strcmp($user->remember_password, $_COOKIE["user"]) == 0)
            {
                Session::set("user", $data);
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Проверить авторизирован ли пользователь
     * @return bool
     */
    public static function check()
    {
        $controller = new self();
        if(!Session::get("user"))
        {
            return $controller->coocies();
        }

        return true;
    }

    /**
     * Форма авторизации
     */
    public function login_form()
    {
        ob_start();
        include __DIR__."/template/login_form.php";
        $str = ob_get_contents();
        ob_end_clean();

        Render::title("Авторизация пользователя");
        Render::desc("Войти на сайт");
        Render::content($str);

        return $this->render("login.php");
    }

    /**
     * Вход пользователя
     * @return string
     */
    public function login()
    {
        $user   = new User();
        $method = "email";

        if(empty($_POST["remember"]))
        {
            $remember = false;
        } else {
            $remember = true;
        }
        if(!empty($_POST["phone"]))
        {
            $method = "phone";
        }

        return $user->login($_POST[$method], $_POST["pass"], $method,  $remember);
    }
}
