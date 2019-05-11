<?php
session_start();
require_once 'configur.php';
mysqli_set_charset($conn,"utf8");
?>
	
<html>

<head>
     <meta charset="utf-8">
	

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300 | Arimo" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bellefair" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo" rel="stylesheet">


	<title>שיפודי התקווה</title>

</head>

<body>
	<header style="font-family: 'Assistant', sans-serif; font-size:14px">

		<div class="row">


			<div class="col-xs-12 col-md-3">

<?php 
						
				isLoggedIn();
				
						function isLoggedIn(){
							$logged = $_SESSION['user'];
							$admin = $_SESSION['admin'];
							
							if($logged){
								
								
								echo '<span class="right" style="color:#222;">שלום, <span id="name">' . $_SESSION['name'][$id] . '</span> <br> <a href="logout.php">התנתק</a> </span>';
								
							}	
							
							else if($admin){
							    echo "הנך מחובר כמנהל";
							    echo "<br> <a href='admin.php'>דף ניהול ראשי</a>";
							    echo '&nbsp &nbsp &nbsp <a href="logout.php" style="color:red;">התנתק</a>';
							}
							else{
								echo "שלום אורח";
								echo "<br><a href='signin.php'>התחבר</a>";
							}
						}
						
						
						

?>
			

			</div>
			<div class="col-md-3">

				<div id="logo">
					<a href="index.html"><img src="images/logo.png" alt="logo" /></a>
				</div>
			</div>


		</div>
	</header>

</body>

</html>
