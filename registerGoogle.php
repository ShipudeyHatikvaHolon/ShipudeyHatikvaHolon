



<!DOCTYPE html>

<?php

include_once 'header.php';

?>

<?php
    require_once "configGoogle.php";
	$loginURL = $gClient->createAuthUrl();
$name=	 $_SESSION['givenName'];
?>
	<html lang="">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>שיפודי התקווה</title>


	</head>

	<body>
			<div class="container">
		<div class="row">
		
				<div class="col-lg-3"></div>

				<div class="col-lg-6" id="formContainer">
					<form method="post" action="registrationGoogle.php">
						<h2 style="color:#41414E;margin-bottom:2%;">הרשמה לאתר</h2>
						<small> שלום <?php echo $name ?> על מנת להשלים את הליך הרישום למספרה אנא בחר סיסמא עבור האתר והכנס טלפון נייד ליצירת קשר</small>


						<div class="input-group">
							<label>סיסמא</label>
							<input type="password" name="password" pattern=".{8,12}" title="אנא הכנס לפחות 8 תווים">
						</div>

						<div class="input-group">
							<label>אימות סיסמא</label>
							<input type="password" name="repassword" pattern=".{8,12}" title="אנא הכנס לפחות 8 תווים">
						</div>

						<div class="input-group">
							<label for="phone">טלפון</label>
							<input id="phone" type="tel" id="phone" name="phone" placeholder="phone" pattern="^(?:0(?!5)(?:2|3|4|8|9))(?:-?\d){7}$|^(0(?=5)(?:-?\d){9})$" title="אנא הכנס מספר טלפון תקין">
						</div>
							<div class="input-group">
							<button type="submit" name="register" class="btn">הרשם</button>
						</div>


						<p>משתמש רשום? <a href="signin.php">התחבר</a></p>


					</form>

				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>
		<?php include('footer.php') ?>
	</body>

	</html>
	
