<?php if ($_SESSION['user_login']) :?>
	<a href="add" class="px40 center">Добавить объявление</a>
<?php endif; 
	$query = "SELECT * FROM `adverts` ORDER BY `adverts`.`date` DESC";
	draw_ad($query);
?>
	