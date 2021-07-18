<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = './login.php';
	} else {
		$uri = './login.php';
	}
	#$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri);
	exit;
?>
