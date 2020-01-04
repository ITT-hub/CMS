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
        Route::set("/login", __NAMESPACE__."\\Auth", "login", "post");
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
            $model->email   = $_POST["email"];
            $model->phone   = $_POST["phone"];

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
     * @param string $login
     * @param string $password
     * @param string $field
     * @param bool $remember
     * @return string
     */
    public function login(string $login, string $password, string $field, $remember = true): string
    {
        $user = UserModel::where($field, $login)->get();

        if(count($user) > 0)
        {
            if(password_verify($password, $user[0]->password))
            {
                if($remember)
                {
                    $this->remember($user[0]->id, 3600 * 24);
                }

                Session::set("user", ["uid" => $user[0]->id, "phone" => $user[0]->phone, "email" => $user[0]->email]);
                Redirect::back();
            } else {
                return "Не верно введен пароль";
            }
        }

        return "Пользователя не существует";
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
