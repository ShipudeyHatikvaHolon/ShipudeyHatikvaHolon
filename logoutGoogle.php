<?php
	require_once "configGoogle.php";
	unset($_SESSION['access_token']);
	$gClient->revokeToken();
	session_destroy();
	header('Location: index.html');
	exit();
?>