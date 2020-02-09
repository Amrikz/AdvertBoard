<?php
	if (!$_SESSION['user_login']) {
		registermessage();
	}
	else{
		?>
		<form method="POST" id="register_form">
			<input type="text" name="title" placeholder="Заголовок" maxlength="<?=LIMITER?>">
			<textarea  name="description" placeholder="Описание" rows="5" cols="60"></textarea>
			<input type="text" name="price" placeholder="Цена" maxlength="<?=LIMITER?>">
			<input type="submit" name="add_ad" value="Добавить объявление" class="header_input">
		</form>
		<?
	}
?>
