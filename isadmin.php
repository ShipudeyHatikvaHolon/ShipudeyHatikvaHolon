<?php

session_start();
?>






<!DOCTYPE html>

<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'header.php';

?>
	<html lang="">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>שיפודי התקווה חולון</title>

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
				<?php
					
if($_SESSION['admin'] != true){
	echo "<center style='padding:20px;'>";
    	echo " אזור זה מיועד למנהלים בלבד";
	echo "<br>";
	echo "הנך מועבר לדף הבית";
	echo "</center>";
}
					?>
				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>

		<script>
			<?php if($_SESSION['admin'] != true): ?>
				setTimeout(function() {
					window.location.href = 'index.php';
				}, 5000);
			<?php endif; ?>
		</script>
		
		<?php include('footer.php') ?>
	</body>

	</html>
	
