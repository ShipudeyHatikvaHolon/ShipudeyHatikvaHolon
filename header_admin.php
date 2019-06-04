<?php
if(!isset($_SESSION))
	session_start();
	
require_once 'configur.php';
mysqli_set_charset($conn,"utf8");
?>
	
<html>

<head>
     <meta charset="utf-8">
	<!-- Required meta tags -->

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300 | Arimo" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bellefair" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo" rel="stylesheet">


	<title>שיפודי התקווה</title>
	<style>
body{
    	font-family: 'Assistant', sans-serif;
}

		.right {
			direction: rtl;
			text-align: right;
		}



}            
        @media (max-width:576px){
             body{
                 margin-bottom:20px;
                 font-size:18px;
                     font-family: 'Assistant', sans-serif;

             }
             
        }
        #logo{float: right;}
	</style>
</head>

<body>
	<header style="font-family: 'Assistant', sans-serif; font-size:14px">

		<div class="row">


			<div class="col-xs-12 col-md-3">

<?php 
						
				isLoggedIn();
				
						function isLoggedIn(){

							if(isset($_SESSION['user'])) {
								$logged = $_SESSION['user'];
							} else {
								$logged = false;
							}

							if(isset($_SESSION['admin'])) {
								$admin = $_SESSION['admin'];
							} else {
								$admin = false;
							}

							
							if($logged){
								
								
								echo '<span class="right" style="color:#222;">שלום, <span id="name">' . $_SESSION['user_name'] . '</span> <br> <a href="logout.php">התנתק</a> </span>';
								
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
					<a href="index.php"><img src="images/logo.png" alt="logo" /></a>
				</div>
			</div>


		</div>
	</header>
</body>

</html>
