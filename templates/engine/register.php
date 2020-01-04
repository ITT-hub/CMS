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
<!--  Header  -->
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
<!--   End header   -->

<!--   Content   -->
<div class="container">
   <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-6">
         <h3 class="mb-2 mt-4">Регистрация нового пользователя</h3>
         <?php foreach($content as $item): ?>
         <?php echo $item; ?>
         <?php endforeach; ?>
      </div>
      <div class="col-lg-3"></div>
   </div>
</div>

<footer>&copy; IT-Technology <?php echo date("Y"); ?></footer>
</body>
</html>