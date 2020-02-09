<?php if (!$_SESSION['user_login']) : ?>
	<form method="POST" id="register_form">
		<input type="text" name="login" placeholder="Логин" maxlength="<?=LIMITER?>">
		<input type="password" name="password" placeholder="Пароль" maxlength="<?=LIMITER?>">
		<input type="password" name="password2" placeholder="Повторите пароль" maxlength="<?=LIMITER?>">
		<input type="submit" name="register" value="Зарегистрироваться" class="header_input">
	</form>
<?php
	  else:
	  	echo "<div class='px40 center vertical-center404'>Вы уже зарегистрированы</div>";
	endif;
?>