

<!DOCTYPE html>

<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'header.php';
require_once 'configur.php';

if(isset($_POST['submit'])) {
	
	$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

	if( !$email ) {
		header('location: contact.php?errorMessage=האימל הוא שדה חובה וחייב להיות אימל תיקני');
		exit;
	}

	if(!$subject || !$message ) {
		header('location: contact.php?errorMessage=ההודעה חייבת להכיל נושא ותוכן');
		exit;
	}

	$sql = "INSERT INTO contacts (id, `subject`, email, content)
	VALUES ('', '$subject', '$email', '$message')";

	$result = mysqli_query($conn, $sql);
	if($result ) {
		header('location: contact.php?message=ההודעה נשלחה בהצלחה');
	} else {
		header('location: contact.php?errorMessage=קרתה טקלה בשליחת ההודעה, אנא נסה שוב מאוחר יותר');
	}
	exit;

}

?>
	<html lang="">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">


		<style>
		    *{
		        margin:0;
		        padding:0;
		    }
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
			input, select,textarea{
				margin-top:2%;
				background: none;
				border:none;
				border-bottom: 3px double #41414e;
				border-radius: 10%;
				
			}
			
			textarea{
				border: 3px double #41414e;
				border-radius: 5%;
			}
			label {
				width: 25%;
			}

			button{
				margin-top: 2%;
				align-content: center;
				
			}
			
			#map{
			    height: 500px;
			    width: 100%;
			}
			
			footer{
				margin-top:5%;
				background: #f1f1f1;
			}
		</style>
	</head>

	<body>
		<?php displayMessage(); ?>
			<div class="container">
		<div class="row">
		
				<div class="col-lg-3"></div>

				<div class="col-lg-6" id="formContainer">
					<form method="post" action="">
					<h2 style="color:#41414E;margin-bottom:2%;">צור קשר</h2>
						<small>אנא שלח את הודעתך ותזכה למענה ב24 השעות הקרובות.</small>
						<p>נושא : <input type="text" name="subject"></p> 
						<p>כתובת מייל : <input type="email" name="email"></p>
						<p>הודעה:</p>
						<p><textarea cols="40" rows="5" name="message"></textarea></p>
						<div class="input-group">
							<button type="submit" name="submit" class="btn">שלח</button>
						</div>

					</form>

				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>
	</body>
    <?php include('footer.php') ?>
	</html>
	
