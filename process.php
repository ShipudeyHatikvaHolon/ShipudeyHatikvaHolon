<?php 
	require_once 'configur.php';
	$connect = $conn;
session_start();

	
	
	$_SESSION['message'] ="";
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);	
				  
	
	$sql = mysqli_query($connect, "select * FROM users where email = '$email'  and password = '$password'") or die("Failed" . mysqli_error());
	$row = mysqli_fetch_assoc($sql);
	
	if($row['email'] == $email && $row['password'] == $password){

		$_SESSION['user_name'] = $row['name'];

		if( $email == "amitbendo@gmail.com"){
			$_SESSION['admin'] = true;
			$_SESSION['adminId'] = $row['user_id'];
			$_SESSION['id'] = $row['user_id'];
			$_SESSION['message']  .= "הנך מועבר לעמוד ניהול המערכת";
			header("refresh:3; url=admin.php");
		}	
		else if($email != "amitbendo@gmail.com"){
		$_SESSION['user'] = true;
		$id = $row['user_id'];
		$_SESSION['id'] = $id;
	// 	foreach($row as $key => $value){
	// $_SESSION[$key][$id] = $value;
	// 	}
		
		
		
		$_SESSION['message']  .= "התחברת בהצלחה!<br>";
		
	
		
	}
	}
	else{
		$_SESSION['message']  .= "לא הצלחת להתחבר<br>
		הנך מועבר לדף ההתחברות.";
		
		header("refresh:3; url=signin.php");
		
	}

	

	?>
	




<html>
	
	
	<head>
		
		<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300 | Arimo" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bellefair" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo" rel="stylesheet">
    		<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">


	<title>שיפודי התקווה</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
		
		
				<style>
		body {
			background: #f5f5f5;
				font-family: 'Assistant', sans-serif;
		}



		#messageDiv {
			padding: 20px;
		border: 3px double #41414e;
				box-shadow: -1px 4px 26px -1px rgba(65,65,78,0.65);
			margin: 0 auto;
			direction: rtl;
			text-align: center;
			margin-top: 100px;
			width:50%;
		}

		#logo a img {
			display: block;
			margin: 0 auto;
			margin-top: 50px;
		}

		button {
			position: relative;
			left: 30%;
			margin-right:0;
			margin-top: 30px;
		}
	#buttons{
	    width:75%;
	    margin-left:12%;
	    margin-bottom:5%;
	}
.button {
  display: inline-block;
  line-height: 3em;
  padding: 0 1em;
  background: #3B3B47;
  border-radius: 0.125em;
  background-clip: padding-box;
	color:#f1f1f1;
	
  
}

		.buttn:hover {
			background: #3cb0fd;
			background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
			background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
			background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
			background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
			background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
			text-decoration: none;
		}
		
		@media (max-width:576px){
		    #buttons{
		        position:relative;
		        
		        width:100%;
		        
		    
		    }
		    button{
		        
		        
		    }
		}

	</style>

	</head>
	
	
	<body>
		
		<main>
		<div id="logo">
							<a href="index.php"><img src="images/logo.png" alt="logo" /></a>
						</div>
			
			<div id="messageDiv">
				
				<?php 
				
				echo $_SESSION['message'];
				
				
				?>
				
			</div>
				</main>
			<div class="container-fiuld">
			<div class="row">
			
						

		<div class="col-lg-1"></div>
		
			<div class="col-lg-9 col-12" id="buttons" style="display:inline-block;">
				<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="index.php"><button 
				class="button">דף הבית</button></a></div>


			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="calendarTest4.php"><button class="button">הזמנת שולחן במסעדה</button></a></div>
			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="deliveries.php"><button class="button">משלוחים </button></a></div>
			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="vouchers.php"><button class="button">רכישת שוברים</button></a></div>
			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="contact.html"><button class="button">צור קשר</button></a></div>
		
		</div>
		<div class="col-lg-2"></div>
			
		

</div>
		



    <?php include 'footer.php'; ?>
		
	</body>
	
	
	
	
</html>
