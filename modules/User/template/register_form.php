<form action="/register" method="post">
   <input type="hidden" name="_cache_" value="<?php echo getCache(); ?>">
   <div class="form-group">
      <label for="phone">Телефон</label>
      <input type="tel" name="phone" class="form-control" id="phone" placeholder="9999 99-99-99">
   </div>
   <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="youname@domain.tdl">
   </div>
   <div class="form-group">
      <label for="name">Ваше имя</label>
      <input type="text" name="name" class="form-control" id="name" placeholder="Как вас зовут">
   </div>
   <div class="form-group">
      <label for="pass">Пароль</label>
      <input type="password" name="password" class="form-control" id="pass" placeholder="Ваш пароль">
   </div>
   <div class="form-group">
      <label for="remember">Пароль</label>
      <input type="password" name="remember" class="form-control" id="remember" placeholder="Повторите пароль">
   </div>
   <div class="form-group text-right">
      <button type="submit" class="itt-btn">Зарегестрироваться</button>
   </div>
</form>
<script>
    $(function($){
        $("#phone").mask("9999-99-99-99");
    });
</script>