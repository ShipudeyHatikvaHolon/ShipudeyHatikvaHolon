<?php
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


        #nav ul a li{

	font-size: 22px;
	padding: 20px;
	margin-left: 30px;
	color:#483D8B;
}            
        @media (max-width:576px){
             #nav ul a li{
                 padding:5px;
                 margin: 0;
                 margin-left:5px;
                
             }
             body{
                 margin-bottom:20px;
                 font-size:18px;
                     font-family: 'Assistant', sans-serif;

             }
             
        }
	</style>
</head>

<body>
	<header style="font-family: 'Assistant', sans-serif; font-size:14px">

		<div class="row">


			<div class="col-xs-12 col-md-3">

<?php 
						
				isLoggedIn();
				
						function isLoggedIn(){
							if( isset($_SESSION['user']) ) {
								$logged = $_SESSION['user'];
							} else  {
								$logged = false;
								$_SESSION['user'] = false;
							}

							if( isset($_SESSION['admin']) ) {
								$admin = $_SESSION['admin'];
							} else  {
								$admin = false;
								$_SESSION['admin'] = false;
							}
							
							if($logged){
								
								
								echo '<span class="right" style="color:#222;">שלום, <span id="name">' . $_SESSION['user_name'] . '</span> <br> <a href="logout.php "style="color:red;">התנתק</a> </span>';
								
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
			<div class="col-xs-12 col-md-6">



				<div id="nav">
					<ul>
						<a  href="calendarTest4.php" >
							<li  style="color:orange;">הזמנת שולחן במסעדה</li>

						</a>
						<a href="deliveries.php">
							<li style="color:orange;">משלוחים</li>

						</a>
						<a href="vouchers.php">
							<li style="color:orange;">רכישת שוברים</li>

						</a>
					</ul>
				</div>
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
