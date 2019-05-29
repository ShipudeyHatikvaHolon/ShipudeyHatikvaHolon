




<!DOCTYPE html>

<?php

include_once 'header.php';

?>
<?php
  require_once "configGoogle.php";
  $loginURL = $gClient->createAuthUrl();
?>
	<html lang="">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>שיפודי התקווה סניף חולון</title>

		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">


		<style>
			html {
				box-sizing: border-box;
				
			}

			body {
				background: #f1f1f1;
			}

			#formContainer {
				direction: rtl;
				box-shadow: 2px 2px red;	
				margin: 0 auto;
				border: 3px double #41414e;
				box-shadow: -1px 4px 26px -1px rgba(65,65,78,0.65);
				background: #fafafa;
			}

			#nav ul a li {

				font-size: 22px;
				padding: 20px;
				margin-left: 30px;
				color: #483D8B;
			}

			form {
				font-family: calibri;
				padding: 5%;
				width:90%;
				position: relative;
				
text-align: right;
				
			}
			input, select{
				margin-top:2%;
				background: none;
				border:none;
				border-bottom: 3px double #41414e;
				border-radius: 10%;
				
			}
			label {
				width: 25%;
			}

			button{
				margin-top: 2%;
				align-content: center;
				
			}
			
			footer{
				margin-top:5%;
				background: #f1f1f1;
			}
		</style>
	</head>

	<body>
			<div class="container">
		<div class="row">
		
				<div class="col-lg-3"></div>

				<div class="col-lg-6" id="formContainer">
					<form method="post" action="registration.php">
						<h2 style="color:#41414E;margin-bottom:2%;">הרשמה לאתר</h2>
						<small> בעוד מספר רגעים תצטרף בתור לקוח למסעדת שיפודי התקווה חולון. אנא מלא את כל הפרטים בטופס מתחתיך ולחץ "הרשם"".</small>
						<div class="input-group">
							<label>שם</label>
							<input type="text" name="name" placeholder="השם שלך" >
						</div>

						<div class="input-group">
							<label>אימייל</label>
							<input type="email" name="email" value="<?php echo $email; ?>">
						</div>

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
							<label for="gender">מגדר</label>
							<select name="gender">
						<option value="male" name="male">זכר</option>
						<option value="female" name="female">נקבה</option>
					</select>
						</div>

						<div class="input-group">
							<button type="submit" name="register" class="btn">הרשם</button>
						</div>
							
						<div class="input-group">
  							 <input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log In With Google" class="btn btn-danger">
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
	
