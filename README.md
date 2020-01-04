### Регистрация пользователя
> В целях безопаности любая форма отправки методом POST должна иметь скрытое поле "cache"

```html
<input type="hidden" name="_cache_" value="<?php echo getCache(); ?>">
```

1. Страница отправки формы регистрации `/register`
2. Шаблон "register.php"

Имена полей для отправки данных

> Поля name, phone, email принимают пустые параметры, поэтому отправить можно только одно из них

* name (null)
* phone (null)
* email (null)
* password
* remember

### Авторизация пользователя

```php
<?php

/*
 * Проверить авторизирован ли пользователь
 * 
 * @return bool
 */
\ITTech\Modules\User\Auth::check();

/*
 * Авторизировать пользователя
 * 
 * @param string $login почта, логин или телефон
 * @param string $password пароль
 * @param bool $remember запомнить = true
 * @return string
 */
\ITTech\Modules\User\Auth::user("login", "password" [,"remember" = false]);

```

1. Страница отправки формы авторизации /login
2. Шаблон "login.php"

Имена полей для отправки данных

* name (null)
* phone (null)
* email (null)
* password
* remember

> Авторизация происходит по одному из полей "name", "phone" или "email"
### Методы классов

>Опции в базе данных

```php
<?php

/*
 * Создать опцию настройки
 * 
 * @param string $param_name ключ опции
 * @param string $param_value значение опции
 * @return bool
 */
\ITTech\APP\Options::set("param_name", "param_value");

/*
 * Выбрать опцию
 * 
 * @param string $param_name ключ опции
 * @return string
 */
\ITTech\APP\Options::get("param_name");
```

> Сессии

```php
<?php

/**
 * Создать сессию
 * 
 * @param string $session_name ключ сессии
 * @param mixed $session_value значение сессии
 * @return bool
 */
\ITTech\APP\Session::set("session_name", "session_value");

/**
 * Выбрать сессию
 * 
 * @param string $session_name ключ сессии
 * @return bool|mixed
 */
\ITTech\APP\Session::get("session_name");

/**
 * Создает временную сессию которая уничтожится после перезагрузки страницы
 * @param string $key ключ сессии
 * @param string $value значение сессии
 */
\ITTech\APP\Session::flash("key", "value");

/**
 * Возвращает временную сессию, после чего сессия уничтожается
 * @param string $key ключ сессии
 */
\ITTech\APP\Session::flash("key");
```

> Переадресация

```php
<?php

/*
 * Переадресация на предыдущую страницу
 */
\ITTech\APP\Redirect::back();

/*
 * Переадресация на указанный URL
 */
\ITTech\APP\Redirect::to("url");
```

> Запросы

```php
<?php

/*
 * Чтение директории
 * 
 * @param string $dir путь к директории
 * @return array массив директорий и файлов
 */
\ITTech\APP\Request::dir("/www/html");

/*
 * Проверка хэш в передаваемом POST методе
 */
\ITTech\APP\Request::checkCache();
```