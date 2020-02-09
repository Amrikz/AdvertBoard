<?
	if (!$_SESSION['user_login']) {
		registermessage();
	}
	else{
		$query = "SELECT * FROM adverts WHERE user_id = '$_SESSION[user_id]'";
		draw_ad($query);
	}
?>