<div style="display: block; position: relative; width: 100%; max-width: 600px; margin: 0 auto">
    <img src="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/images/logo.png" alt="IT-Technology" style="height: 50px; margin: 10px auto">
    <div style="display:block; position: relative; border: 10px solid #d8e2c9; padding: 10px;">
        <h2 style="padding-left: 70px; min-height: 50px; width: 300px; max-width: 500px; background: url(http://<?php echo $_SERVER["HTTP_HOST"]; ?>/images/email.png) no-repeat; background-size: 50px 50px;">Подтверждение адреса электронной почты</h2>
        <hr>
        <p>Вы запросили подтверждение адреса электронной почты. Запрос сделан <?php echo date("d.m.Y"); ?> в <?php echo date("H:i.s"); ?> с IP <?php echo $_SERVER["REMOTE_ADDR"]; ?> (<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>).</p>
        <p>Для завершения скопируйте строку <i style="color: #d9534f">http://<?php echo $_SERVER["HTTP_HOST"]; ?>/user/confirm?_cache=<?php echo $cache; ?></i> в адресную строку браузера, или перейдите по кнопке ниже.</p>
        <p>
            <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/user/confirm?_cache=<?php echo $cache; ?>" style="display: block; width: 60%; margin: 30px auto; text-align: center; padding: 20px; background: #5bc0de; color: #ffffff; font-size: 24px; text-decoration: none" target="_blank">Подтвердить Email</a>
        </p>
    </div>
</div>