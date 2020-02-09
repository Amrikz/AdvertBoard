<?php

$url = $_GET['url'];

require 'components/lib/mainFunctions.php';
require 'components/header.php';

switch ($url) {
	case '':
		require 'components/home.php';
		break;
	case 'home':
		require 'components/home.php';
		break;
	case 'register':
		require 'components/register.php';
		break;
	case 'account':
		require 'components/account.php';
		break;
	case 'add':
		require 'components/add.php';
		break;
	case 'myads':
		require 'components/myads.php';
		break;
	case 'view':
		require 'components/view.php';
		break;
	default:
		require 'components/404.php';
		break;
}

require 'components/footer.php';

?>