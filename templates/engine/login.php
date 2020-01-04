<!doctype html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <base href="/templates/engine/">
   <title><?php if ($title) echo $title ?></title>
   <!--   Website style  -->
   <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/it-tech.css">
   <link rel="stylesheet" href="css/style.css">

   <!-- JavaScripts include file -->
   <script src="js/jquery-3.4.1.min.js"></script>
   <script src="js/jquery.maskedinput.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-3">
            <a href="/" class="logo"></a>
         </div>
         <div class="col-lg-9">

            <div class="user-block">
               <select name="cyty" id="cyty">
                  <option value="1">Улан-Удэ</option>
               </select>
               <button type="button" class="itt-btn">Доставить груз</button>
               <button type="button" class="itt-btn">Найти водителя</button>
               <a href="/login" class="itt-login">Войти</a>
            </div>

         </div>
      </div>
   </div>
   <div class="bg-header">
      <div class="bg">
         <h1>Нанимайте лучших водителей</h1>
         <div class="users-block">
            <div class="user-block">
               <div>
                  <img src="img/no-user-circle.jpg" alt="User">
               </div>
               Владимир
            </div>
            <div class="user-block">
               <div>
                  <img src="img/no-user-circle.jpg" alt="User">
               </div>
               Баир
            </div>
            <div class="user-block">
               <div>
                  <img src="img/no-user-circle.jpg" alt="User">
               </div>
               Мухан
            </div>
            <div class="user-block">
               <div>
                  <img src="img/no-user-circle.jpg" alt="User">
               </div>
               Сергей
            </div>
            <div class="user-block">
               <div>
                  <img src="img/no-user-circle.jpg" alt="User">
               </div>
               Роман
            </div>
         </div>
      </div>
   </div>

   <div class="container">
      <div class="row">
         <div class="col-lg-6">
            <div class="login-form">
               <h3>Войти</h3>
               <small>С помощью соцсетей</small>
               <div class="social mb-3">
                  <a href="" style="color: #5181b8"><i class="icon-vk"> </i></a>
                  <a href="" style="color: #f7931e"><i class="icon-ok"> </i></a>
                  <a href="" style="color: #168de2"><i class="icon-mail"> </i></a>
                  <a href="" style="color: #36aee2"><i class="icon-telega"> </i></a>
                  <a href="" style="color: #693f93"><i class="icon-viber"> </i></a>
               </div>

               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="t" id="t" value="option1">
                  <label class="form-check-label" for="t">С помощью телефона</label>
               </div>

               <form action="/login" method="post">
                  <input type="hidden" name="_cache_" value="<?php echo getCache(); ?>">
                  <div class="tel-block">
                     <div class="col-auto">
                        <label class="sr-only" for="phone">Телефон</label>
                        <div class="input-group mb-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">+7</div>
                           </div>
                           <input type="tel" name="phone" class="form-control" id="phone" placeholder="9999 99-99-99">
                        </div>
                     </div>
                  </div>
                  <div class="email-block">
                     <div class="col-auto">
                        <label class="sr-only" for="email">Email</label>
                        <div class="input-group mt-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text">@</div>
                           </div>
                           <input type="email" name="email" class="form-control" id="email" placeholder="youname@domain.tdl">
                        </div>
                     </div>
                  </div>
                  <div class="col-auto">
                     <label class="sr-only" for="pass">Пароль</label>
                     <div class="input-group mt-4 mb-4">
                        <div class="input-group-prepend">
                           <div class="input-group-text"><i class="icon-circle"></i></div>
                        </div>
                        <input type="password" name="password" class="form-control" id="pass" placeholder="Ваш пароль">
                     </div>
                  </div>
                  <div class="form-group form-check">
                     <input type="checkbox" name="remember" class="form-check-input" id="remember">
                     <label class="form-check-label" for="remember">Запомнить</label>
                  </div>
                  <div class="form-group text-right">
                     <button type="submit" class="itt-btn">Войти</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-lg-6">

            <div class="login-form">
               <h3>Регистрация</h3>

               <form action="/user/register" method="post">
                  <input type="hidden" name="_cache_" value="<?php echo getCache(); ?>">
                  <div class="col-auto">
                     <label class="sr-only" for="r_phone">Телефон</label>
                     <div class="input-group mt-4 mb-4">
                        <div class="input-group-prepend">
                           <div class="input-group-text">+7</div>
                        </div>
                        <input type="tel" name="phone" class="form-control" id="r_phone" placeholder="9999 99-99-99">
                     </div>
                  </div>
                  <div class="col-auto">
                     <label class="sr-only" for="r_email">Email</label>
                     <div class="input-group mt-2">
                        <div class="input-group-prepend">
                           <div class="input-group-text">@</div>
                        </div>
                        <input type="email" name="email" class="form-control" id="r_email" placeholder="youname@domain.tdl">
                     </div>
                  </div>
                  <div class="col-auto">
                     <label class="sr-only" for="r_pass">Пароль</label>
                     <div class="input-group mt-4 mb-4">
                        <div class="input-group-prepend">
                           <div class="input-group-text"><i class="icon-circle"></i></div>
                        </div>
                        <input type="password" name="pass" class="form-control" id="r_pass" placeholder="Ваш пароль">
                     </div>
                  </div>
                  <div class="col-auto">
                     <label class="sr-only" for="remember">Пароль</label>
                     <div class="input-group mt-4 mb-4">
                        <div class="input-group-prepend">
                           <div class="input-group-text"><i class="icon-circle"></i></div>
                        </div>
                        <input type="password" name="remember" class="form-control" id="remember" placeholder="Повторите пароль">
                     </div>
                  </div>
                  <div class="form-group text-right">
                     <button type="submit" class="itt-btn">Зарегестрироваться</button>
                  </div>
               </form>
            </div>

         </div>
      </div>
   </div>

   <footer>&copy; IT-Technology <?php echo date("Y"); ?></footer>

   <script>
       $(function($){
           $("#phone").mask("9999-99-99-99");
           $("#r_phone").mask("9999-99-99-99");
       });

       $("#t").change(function () {
           $(".email-block").toggle(500);
           $(".tel-block").toggle(500);
       });
   </script>
</body>
</html>