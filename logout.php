<?php
session_start();
if($_SESSION['user']){
unset($_SESSION['user']);
}
if($_SESSION['admin'])
{
unset($_SESSION['admin']);
}

session_destroy();
include_once 'header.php';

header('refresh:2; url=index.php');

?>


<html>
	
	<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="subscribe.css" />
	
	<script src="subscribe.js"></script>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
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
		<center style='padding:20px;'>
		<h3 style="padding:5px;">הנך מועבר לדף הבית</h3>
		</center>
				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>
		<?php include('footer.php') ?>
	</body>
</html>
