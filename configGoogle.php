<?php
	session_start();
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("468774801861-faphqsgad9e4ou9mv87jpf637edoveb2.apps.googleusercontent.com");
	$gClient->setClientSecret("OCxLa3cBmuJcENlS2UgJ-oJi");
	$gClient->setApplicationName("Shipudey Hatikva web");
	$gClient->setRedirectUri("https://robiso.mtacloud.co.il/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
