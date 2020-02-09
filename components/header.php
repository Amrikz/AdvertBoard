<!DOCTYPE html>
<html>
	<head>
		<title>OH HELLO THERE</title>
		<link rel="stylesheet" type="text/css" href="style/style.css">
	</head>
	<body>
		<div class="border-under" id="header">
			<a href="home" class="px40 decoration-none logo">Главная</a>
			<?php if (!$_SESSION['user_login']) : ?>
			<form method="POST" id="right_links">
				<input type="text" name="login" placeholder="Логин" maxlength="<?=LIMITER?>">
				<input type="password" name="password" placeholder="Пароль" maxlength="<?=LIMITER?>" style="margin-left: 10px;">
				<input type="submit" name="sign_in" value="Войти" class="header_input">
				<a href="register" class="decoration-none">Зарегистрироваться</a>
			</form>
			<?php
			else:
				?>
				<a href="myads" class="decoration-none flex-center px20">Мои объявления</a>
				<form method="POST" id="right_links">
					<a href="account" class="px40 decoration-none"><?=$_SESSION['user_login']?></a>
					<input type="submit" name="exit" value="Выходишь?" class="header_input" style="margin: 10px 0 0 10px;">
				</form>
				<?php
			endif; ?>
		</div>

		<!--Вывод ошибок-->
		<?php
		if (!$messages) {
			$messages = [];
		}
			foreach ($messages as $key => $value) {
		 		echo "<p class='message center'>$value</p>";
		 	}
		?>

