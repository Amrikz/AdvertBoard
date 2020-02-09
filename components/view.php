<?php
	$query = "SELECT * FROM `adverts` WHERE id = '$_GET[view]'";
	$data = mysqli_query($dbc,$query);
	$info = mysqli_fetch_assoc($data);
	$query = "SELECT login,name,surname FROM `users` WHERE id = '$info[user_id]' LIMIT 1";
	$user_data = mysqli_query($dbc,$query);
   	$user_info = mysqli_fetch_assoc($user_data);
	?>
	<p class="px40 center"><?=$info['title']?></p>
	<b class="px20 center"><?php echo $user_info['name'].' '.$user_info['surname'].' | '.$user_info['login']?></b>
	<b class="px20 center">Цена: <?=$info['price']?></b>
	<p class="ad_full_desc center"><?=$info['description']?></p>
	<?
?>