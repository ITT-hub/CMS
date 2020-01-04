<?php
/*
 * Created 17.12.2019 10:57
 */

namespace ITTech\Modules\User;

use ITTech\APP\Controller;
use ITTech\APP\eMail;
use ITTech\APP\Main;
use ITTech\APP\Options;
use ITTech\APP\Redirect;
use ITTech\APP\Render;
use ITTech\APP\Session;
use ITTech\Lib\Route;

/**
 * Class User
 * @package ITTech\Modules\User
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class User extends Controller
{
    private $cache = null;
    /**
     * Маршрутизация
     */
    public static function route()
    {
        Route::set("/login", __NAMESPACE__."\\Auth", "login_form");
        Route::set("/login", __CLASS__, "login", "post");
        Route::set("/register", __CLASS__, "registerForm");
        Route::set("/register", __CLASS__, "create", "post");

        Route::set("/user/confirm", __CLASS__, "user_confirm");
    }

    /**
     * Регистрация пользователя
     */
    public function create()
    {
        try {
            $model          = new UserModel();
            if(!empty($_POST["email"]))
            {
                $model->email   = $_POST["email"];
            }
            if(!empty($_POST["phone"]))
            {
                $model->phone   = $_POST["phone"];
            }
            if(!empty($_POST["name"]))
            {
                $model->name    = $_POST["name"];
            }

            if($_POST["password"] == $_POST["remember"])
            {
                $model->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            } else {
                exit("Пароль не совпадает с проверкой");
            }

            if(Options::get("register") == 0)
            {
                $this->cache = md5($_SERVER["HTTP_HOST"]."-".time());
                $model->remember_password = $this->cache;
            }
            $model->enable = Options::get("register");
            $result        = $model->save();

            if($result)
            {
                $this->confirm($result);
                Session::flash("system", "Регистрация завершена");
                return Redirect::to("/");
            }
        } catch (\Exception $e)
        {
            echo "Ошибка: ".$e->getMessage();
        }
    }

    /*
     * Отправка подтверждения почты
     */
    protected function confirm(int $userID): void
    {
        if(Options::get("register") == 0)
        {
            $cache = $this->cache;

            ob_start();
            include __DIR__."/template/confirm_email.php";
            $str = ob_get_contents();
            ob_end_clean();

            $user = UserModel::find($userID);
            $user->remember_password = $cache;

            if($user->save())
            {
                $mail  = new eMail($user->email, "Подтверждение почты ".Options::get("site_name"));
                $wMail = new eMail(Options::get("admin_email"), "Регистрация пользователя ".Options::get("site_name"));

                $mail->from(Options::get("support_email"));
                $mail->send($str);
                $wMail->send("Новый идентификатор пользователя ".$userID);
            }
        }
    }

    /**
     * Подтверждение почты пользователя
     */
    public function user_confirm()
    {
        if(!empty($_GET["_cache"]) && !is_null($_GET["_cache"]))
        {
            $user = UserModel::where("remember_password", $_GET["_cache"])->get();
            $time = 3600 * 72 + strtotime($user[0]->created); // Время на подтверждение 3 суток

            if($time <= time())
            {
                exit("Истек срок подтверждения");
            }

            $user[0]->remember_password = null;
            $user[0]->enable = 1;

            if($user[0]->save())
            {
                Session::flash("system", "Почта подтверждена");
                Redirect::to("/");
            }
        }

        exit("Не верный параметр запроса");
    }

    /**
     * Авторизировать пользователя
     * @return string
     */
    public function login()
    {
        if(!empty($_POST["name"]))
        {
            $login = $_POST["name"];
        }
        if(!empty($_POST["email"]))
        {
            $login = $_POST["email"];
        }
        if(!empty($_POST["phone"]))
        {
            $login = $_POST["phone"];
        }
        if(empty($_POST["remember"]))
        {
            $remember = false;
        } else {
            $remember = true;
        }

        return Auth::user($login, $_POST["password"], $remember);
    }


    /**
     * Форма регистрации пользователя
     */
    public function registerForm()
    {
        ob_start();
        include __DIR__."/template/register_form.php";
        $str = ob_get_contents();
        ob_end_clean();

        Render::title("Регистрация");
        Render::desc("Создать нового пользователя");
        Render::content($str);

        return $this->render("register.php");
    }
}
