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
     * Авторизировать пользователя
     *
     * @param string $login
     * @param string $password
     * @param bool $remember
     * @return string
     */
    public static function user(string $login, string $password, $remember = false)
    {
        $class = new self();
        $user  = self::find_user($login);

        if(!$user)
        {
            return "Пользователя не существует";
        }

        if($user->enable == 0)
        {
            Session::flash("system", "Пользователь не активирован");
            return Redirect::back();
        }

        if(password_verify($password, $user->password))
        {
            if($remember)
            {
                $class->remember($user->id, Options::get("remember_time"));
            }

            Session::set("user", ["uid" => $user->id, "phone" => $user->phone, "email" => $user->email]);
            Redirect::back();
        } else {
            return "Не верно введен пароль";
        }
    }

    /**
     * Запомнить пользователя
     * @param int $userID
     * @param $remember_time
     */
    protected function remember(int $userID, $remember_time)
    {
        $user          = UserModel::find($userID);
        $time          = time() + $remember_time;
        $filename      = md5($user->email.time());
        $data["uid"]   = $user->id;
        $data["phone"] = $user->phone;
        $data["email"] = $user->email;
        $data["ip"]    = $_SERVER["REMOTE_ADDR"];
        $data["time"]  = $time;

        if(file_put_contents(Main::$root."/tmp/cache/".$filename, serialize($data)))
        {
            $user->remember_password = $filename;
            setcookie("user", $filename, $time, "/");
            $user->save();
        }
    }

    /*
     * Проверить существование пользователя
     */
    protected static function find_user($login)
    {
        $user = UserModel::where("name", $login)->get();

        if(empty($user))
        {
            $user = UserModel::where("email", $login)->get();
        }
        if(empty($user))
        {
            $user = UserModel::where("phone", $login)->get();
        }

        if(empty($user))
        {
            $user = UserModel::where("phone", $login)->get();
        }

        if(!empty($user))
        {
            return $user[0];
        }

        return false;
    }
}
