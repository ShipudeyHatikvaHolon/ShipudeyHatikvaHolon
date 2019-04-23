<?php 

session_start();

		?>




<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>שיפודי התקווה סניף חולון</title>



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

	<footer>
		<div class="row">



			<div class="col-12">
				<div id="footerLinks">
					<ul>
						<a href="#">
							<li>על האתר</li>
						</a>
						<a href="#">
							<li>איך מגיעים </li>
						</a>
						<a href="#">
							<li>צור קשר</li>
						</a>


					</ul>
					<p>הפלד 7, חולון מס' 03-6412849</p>
					<p style="font-size: 12px;">&copy כל הזכויות שמורות לעמית בנדט, רובי סומך ועידן זולברג</p>
				</div>

			</div>




		</div>

	</footer>
	
</body>


</html>
