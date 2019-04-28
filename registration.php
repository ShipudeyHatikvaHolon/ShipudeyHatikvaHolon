<?php
require_once 'configur.php';

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
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$repassword = mysqli_real_escape_string($conn, $_POST['repassword']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$gender = mysqli_real_escape_string($conn, $_POST['gender']);
	
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
		

    	$mail->Host = "smtp.gmail.com";
    	$mail->SMTPSecure = "ssl";
    	$mail->Port = 465;
    	$mail->SMTPAuth = true;
    	$mail->Username = 's.hatikva2018@gmail.com';
    	$mail->Password = 'Rs123456';	
    	$mail->setFrom('s.hatikva2018@gmail.com', 'שיפודי התקווה');
    	$mail->addAddress('amitbendet@gmail.com' );
    	$mail->Subject = "new user!";
    	$mail->Body="יוזר חדש נרשם "."\n"."\n";
    	$mail->Body.="$name "."\n"; 
    	$mail->Body.="$email"."\n"; 
    	$mail->Body.="$phone "."\n"; 
        if ($mail->send())
    	{
    	    ;
    	}
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
		echo "נרשמת בהצלחה!<br>תוכל להזמין תורים לאחר אישור חשבונך ב-24 השעות הקרובות.";
		
			 echo'</p>';
			
		echo "<a href='signin.php'>עבור לדף ההתחברות</a>";
		  echo '</center>';
	}
	
					
					?>		
				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>
		
	</body>
	
	
	
