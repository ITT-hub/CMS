<!doctype html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?php echo $title; ?></title>
</head>
<body>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
   echo "<h1>Регистрация завершена</h1>";
} else {
    foreach ($content as $value)
    {
        echo $value;
    }
}

?>
</body>
</html>