<?php 
	
session_start();

	
	
	$_SESSION['message'] ="";
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	
	
	$connect = mysqli_connect('localhost:3306', 'robiso', 'rakmaccabi', 'robiso_hatikva');
	mysqli_set_charset($connect,"utf8");
				  
	
	$sql = mysqli_query($connect, "select * FROM users where email = '$email'  and password = '$password'") or die("Failed" . mysql_error());
	$row = mysqli_fetch_assoc($sql);
	
	if($row['email'] == $email && $row['password'] == $password){
		if( $email == "amitbendo@gmail.com"){
			$_SESSION['admin'] = true;
			$_SESSION['message']  .= "הנך מועבר לעמוד ניהול המערכת";
		}	
		else if($email != "amitbendo@gmail.com"){
		$_SESSION['user'] = true;
		$id = $row['id_user'];
		$_SESSION['id'] = $id;
		foreach($row as $key => $value){
	$_SESSION[$key][$id] = $value;
		}
		
		
		
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
	


	<title>שיפודי התקווה</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
		
		

	</head>
	
	
	<body>
		
		<main>
		<div id="logo">
							<a href="index.html"><img src="images/logo.png" alt="logo" /></a>
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
				<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="index.html"><button 
				class="button">דף הבית</button></a></div>


			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="#"><button class="button">הזמן מקום</button></a></div>
			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="#"><button class="button">הזמן משלוח </button></a></div>
			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="vouchers.php"><button class="button">רכישת שוברים</button></a></div>
			<div class="col-lg-2 col-sm-6" style="display:inline-block;"><a href="contact.html"><button class="button">צור קשר</button></a></div>
		
		</div>
		<div class="col-lg-2"></div>
			
		

</div>
		
	<?php include 'footer.php'; ?>

	</body>
	
	
</html>
