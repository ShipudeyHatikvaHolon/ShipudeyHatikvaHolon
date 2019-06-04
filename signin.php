<?php 

include_once 'header.php';

?>

<!DOCTYPE html>
<html>

<head>
	<script src="fort.min.js"></script>
	<link rel="stylesheet" href="fort.min.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300 | Arimo" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bellefair" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">

	<title>שיפודי התקווה סניף חולון</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" type="text/css" href="signin.css">


<style>
	
	</style>


</head>

<body>

<center>
	<div id="signInBox">
		<form method="post" action="process.php">
		    
		    <h2 style="padding:5px;margin-bottom:3px;position:relative;left:3%; color:#41414e;text-align:right;">התחברות לאתר</h2>
			<p class="text"><label>כתובת מייל</label>
			<input type="email" autofocus name="email" required></p>
			<p class="text"><label>סיסמא</label>
			<input type="password" name="password" required> </p>
            
			

			<input class="button" type="submit" name="login" value="התחבר" />
			<p>לא רשום? הרשם <a href="register.php">כאן!</a></p>
		</form>
	</div>
</center>

	    <?php include 'footer.php'; ?>

</body>


</html>
