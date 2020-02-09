<?php
	session_start();

	require 'db.php';

	define('LIMITER', 100);

	// Вход пользователей
	if ($_POST['sign_in']) {
		if ($_POST['login']) {
			if ($_POST['password']) {
				$query = "SELECT id,login,name,surname FROM users WHERE login = ? AND password = ? LIMIT 1";
	      		$stmt = mysqli_prepare($dbc,$query);
	      		mysqli_stmt_bind_param($stmt, 'ss' , $_POST['login'], $_POST['password']);
	      		mysqli_stmt_execute($stmt);
	      		$name && $surname = ' ';
	     		mysqli_stmt_bind_result($stmt,$id,$user,$name,$surname);
	    		mysqli_stmt_fetch($stmt);
	    		if ($user) {
	    			$_SESSION['user_id'] = $id;
	    			$_SESSION['user_login'] = $user;
	    			$_SESSION['user_name'] = $name;
	    			$_SESSION['user_surname'] = $surname;
	    		}
	    		else {
	    			$messages[] = "Вы ввели неправильную комбинацию логин/пароль либо такого аккаунта не существует";
	    		}
			}
			else {
				$messages[] = "Введите пароль";
			}
		}
		else {
			$messages[] = "Введите логин";
		}
	}

	// Регистрация пользователей
	if ($_POST['register']) {
		if ($_POST['login']) {
			if ($_POST['password'] && $_POST['password2']) {
				if ($_POST['password'] == $_POST['password2']) {
					$query = "SELECT login FROM users WHERE login = ? LIMIT 1";
	      			$stmt = mysqli_prepare($dbc,$query);
	      			mysqli_stmt_bind_param($stmt, 's' , $_POST['login']);
	      			mysqli_stmt_execute($stmt);
	      			mysqli_stmt_bind_result($stmt,$user);
	      			mysqli_stmt_fetch($stmt);
	      			if (!$user) {
	      				$query = "INSERT INTO `users` (`id`, `login`, `password`, `name`, `surname`) VALUES (NULL, ?, ?, ' ', ' ')";
	      				$stmt = mysqli_prepare($dbc,$query);
		      			mysqli_stmt_bind_param($stmt, 'ss' , $_POST['login'] , $_POST['password']);
		      			mysqli_stmt_execute($stmt);
	      				$_SESSION['user_login'] = $_POST['login'];
	      				$query = "SELECT id,login,name,surname FROM users WHERE login = '$_SESSION[user_login]' LIMIT 1";
	      				$data = mysqli_query($dbc,$query);
	      				$info = mysqli_fetch_assoc($data);
	      				$_SESSION['user_id'] = $info['id'];
	      			}
	      			else {
	      				$messages[] = "Пользователь с таким именем уже существует";
	      			}
				}					
				else {
					$messages[] = "Пароли не совпадают";
				}
			}
			else {
				$messages[] = "Введите пароль";
			}
		}
		else {
			$messages[] = "Введите логин";
		}
	}

	// Выход из аккаунта
	if ($_POST['exit']) {
		session_unset();
		session_destroy();
	}

	// Смена имени,фамилии
	if ($_POST['change_name']) {
		if ($_POST['password']) {
			if ($_POST['name'] || $_POST['surname']) {
				$query = "SELECT id FROM users WHERE login = '$_SESSION[user_login]' AND password = ?";
				$stmt = mysqli_prepare($dbc,$query);
	      		mysqli_stmt_bind_param($stmt, 's' , $_POST['password']);
	      		mysqli_stmt_execute($stmt);
	      		mysqli_stmt_bind_result($stmt,$id);
	      		mysqli_stmt_fetch($stmt);
	      		if ($id) {
	      			if ($_POST['name']) {
	      				require 'db.php';
	      				$query = "UPDATE users SET name = ? WHERE users.id = $id";
	      				$stmt = mysqli_prepare($dbc,$query);
			      		mysqli_stmt_bind_param($stmt, 's' , $_POST['name']);
			      		mysqli_stmt_execute($stmt);
			      		$_SESSION['user_name'] = $_POST['name'];
	      			}
	      			if ($_POST['surname']) {
	      				require 'db.php';
	      				$query = "UPDATE `users` SET `surname` = ? WHERE `users`.`id` = $id";
	      				$stmt = mysqli_prepare($dbc,$query);
			      		mysqli_stmt_bind_param($stmt, 's' , $_POST['surname']);
			      		mysqli_stmt_execute($stmt);
	    				$_SESSION['user_surname'] = $_POST['surname'];
	      			}
	      		}
				else{
					$messages[] = 'Неправильный пароль';
				}
			}
			else {
				$messages[] = 'Введите имя или фамилию';
			}
		}
		else{
			$messages[] = 'Введите свой текущий пароль';
		}
	}

	// Добавление объявления
	if ($_POST['add_ad']) {
		if ($_POST['title'] && $_POST['description'] && $_POST['price']) {
			$query = "INSERT INTO `adverts` (`id`, `title`, `description`, `price`, `date`,  `user_id`) VALUES (NULL, ?, ?, ?, current_timestamp(), ?)";
			$stmt = mysqli_prepare($dbc,$query);
	      	mysqli_stmt_bind_param($stmt, 'ssii' , $_POST['title'] , $_POST['description'] , $_POST['price'], $_SESSION['user_id']);
	      	mysqli_stmt_execute($stmt);
	 		$messages[] = 'Объявление успешно добавлено!';
		}
		else{
			$messages[] = 'Одно или несколько полей не заполнено';
		}
	}

	// Удаление обзявления
	if ($_POST['ad_delete']) {
		$query = "SELECT * FROM `adverts` WHERE id = '$_POST[ad_delete]'";
		$data = mysqli_query($dbc,$query);
		$info = mysqli_fetch_assoc($data);
		if ($_SESSION['user_id'] == $info['user_id']) {
			$query = "DELETE FROM adverts WHERE adverts.id = '$_POST[ad_delete]'";
			mysqli_query($dbc,$query);
		}
	}

	// Просьба о входе/регистрации
	function registermessage () { ?>
	<div class="px40 center vertical-center404">Войдите или зарегистрируйтесь,чтобы просматривать данную страницу.</div>
	<?
	}


	// Функция отрисовки объявлений
	function draw_ad ($query,$limit = -1) {
		require 'db.php';
		$counter = 0;
		$data = mysqli_query($dbc,$query);
		$info = mysqli_fetch_assoc($data);;
		while ($info) {
			if ($counter == $limit) {
				break;
			}
			$query = "SELECT login,name,surname FROM `users` WHERE id = '$info[user_id]' LIMIT 1";
		   	$user_data = mysqli_query($dbc,$query);
		   	$user_info = mysqli_fetch_assoc($user_data);
			?>
			<a href="view?view=<?=$info['id']?>" class="decoration-none">
				<div class="advert center">
					<div class="ad_initials">
						<b><?php echo $user_info['name'].' '.$user_info['surname'].' | '.$user_info['login']?></b>
						<?if ($info['user_id'] == $_SESSION['user_id']) : ?>
							<form method="POST">
								<button name="ad_delete" value="<?=$info['id']?>">Удалить</button>
							</form>
						<? endif; ?>
						<p><?=$info['date']?></p>
					</div>
					<p class="ad_desc"><?=$info['description']?></p>
					<p class="center">
						<b> <?=$info['title']?> | Цена: <?=$info['price']?></b>
					</p>
				</div>
			</a>
			<?
			$info = mysqli_fetch_assoc($data);
			$counter++;
		}
		if ($counter == 0) {
			echo "<p class='center'>Извините,здесь ничего нет</p>";
		}
	}


?>