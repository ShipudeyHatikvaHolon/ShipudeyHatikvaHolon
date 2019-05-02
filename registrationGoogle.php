
<?php
require_once 'configur.php';
  include_once 'header.php';

	if (!isset($_SESSION['access_token'])) 
	{
		
		exit();
	}
?>


	<?php

$name = "";
$email = "";
$password = "";
$repassword = "";
$phone = "";
$gender = "";
$errors = array();

if(isset($_POST['register']))
{
	$name = $_SESSION['givenName']." ". $_SESSION['familyName'];
	$email =$_SESSION['email'] ;
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$repassword = mysqli_real_escape_string($conn, $_POST['repassword']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$gender =$_SESSION['gender'] ;
	
	if(empty($name)){
	array_push($errors, "אנא הכנס שם");
}

if(empty($email)){
	array_push($errors, "אנא הכנס אימייל");
}

if(empty($password)){
	array_push($errors, "אנא הכנס סיסמא");
}
	
	if($password != $repassword){
	array_push($errors, "אנא הכנס סיסמאות זהות");
		
	}
	
	if(empty($phone)){
	array_push($errors, "אנא הכנס מספר טלפון");
}
	
	// check if mail exists already
	
	$user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  	$result = mysqli_query($conn, $user_check_query);
  	$user = mysqli_fetch_assoc($result);

    if ($user['email'] === $email) {
      array_push($errors, "כתובת מייל זו כבר קיימת במערכת");
    }
}


	
	if (count($errors) == 0){
		
		$sql = "INSERT INTO users (name, gender, email, phone, password) VALUES ('$name','$gender','$email','$phone','$password')";
		mysqli_query($conn, $sql);
	}
	
	
	

?>





<!DOCTYPE html>


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
	<?php
					
					
					if(count($errors) > 0){
	echo '<center class="error">';
			foreach($errors as $error):
				echo '<p>';
		echo $error;
			 echo'</p>';
			endforeach;
		echo "<a href='register.php'>חזור אחורה</a>";
		  echo '</center>';
		
	}
	
	else{
	    echo '<center class="error">';
			
				echo '<p>';
		echo "נרשמת בהצלחה!";
			 echo'</p>';
			
		echo "<a href='signin.php'>עבור לדף ההתחברות</a>";
		  echo '</center>';
	}
	
					
					?>		
				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>
		<?php include('footer.php') ?>
	</body>

	
	<?php
	require_once "configGoogle.php";
	unset($_SESSION['access_token']);
	$gClient->revokeToken();
	session_destroy();
	?>
