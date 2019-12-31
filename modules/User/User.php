<?php
/*
 * Created 17.12.2019 10:57
 */

namespace ITTech\Modules\User;

use ITTech\APP\Controller;
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
    /**
     * Маршрутизация
     */
    public static function route()
    {
        Route::set("/user/login", __NAMESPACE__."\\Auth", "login_form");
        Route::set("/user/login", __NAMESPACE__."\\Auth", "login", "post");
        Route::set("/user/register", __CLASS__, "registerForm");
        Route::set("/user/register", __CLASS__, "create", "post");
    }

    /**
     * Регистрация пользователя
     */
    public function create()
    {
        try {
            $model        = new UserModel();
            $model->email = $_POST["email"];
            $model->tel   = $_POST["phone"];

            if($_POST["pass"] == $_POST["remember"])
            {
                $model->password = password_hash($_POST["pass"], PASSWORD_DEFAULT);
            } else {
                exit("Пароль не совпадает с проверкой");
            }
            $model->enable = Options::get("register");

            if($model->save())
            {
                Render::title("Регистрация");
                Render::desc("Создать нового пользователя");
                Render::content("Регистрация завершена!");

                return $this->render("register.php");
            }
        } catch (\Exception $e)
        {
            echo "Ошибка: ".$e->getMessage();
        }
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
