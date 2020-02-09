<?php
	if (!$_SESSION['user_login']) {
		registermessage();
	}
	else {
		?>
		<p class="px40 center"><?=$_SESSION['user_login']?></p>
		<p class="px40 center"><?php echo $_SESSION['user_name']." ".$_SESSION['user_surname'];?></p>
		<form method="POST" id="register_form">
			<input type="text" name="name" placeholder="Имя" maxlength="<?=LIMITER?>">
			<input type="text" name="surname" placeholder="Фамилия" maxlength="<?=LIMITER?>">
			<input type="password" name="password" placeholder="Текущий пароль" maxlength="<?=LIMITER?>">
			<input type="submit" name="change_name" value="Изменить" class="header_input">
		</form>
		<?
	}
?>