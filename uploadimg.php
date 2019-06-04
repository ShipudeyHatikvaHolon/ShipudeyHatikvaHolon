	<?php

require_once 'configur.php';

if (isset($_POST['submit'])){

	$valid = false;
	$name = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ); 
	$description = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING) ); 
	$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING); 
	$cost_price = filter_input(INPUT_POST, 'cost_price', FILTER_SANITIZE_STRING); 
	$min_amount = filter_input(INPUT_POST, 'min_amount', FILTER_SANITIZE_STRING); 

	if( !empty($_FILES['file']['name'])) {
	
		$file = $_FILES['file'];
		
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize= $_FILES['file']['size'];
		$fileError= $_FILES['file']['error'];
		$fileType= $_FILES['file']['type'];
		
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		
		$allowed = array('jpg', 'jpeg', 'png');
		
		if(in_array($fileActualExt, $allowed)){
			if($fileError === 0){
				if($fileSize < 1024 * 1024 * 1024 * 5){
					$fileNewName = uniqid('',true).".".$fileActualExt;
					$fileDestination = 'images/'.$fileNewName;
					
					$sql = "INSERT INTO products ( `name`, `description`, `price`, `cost_price`, `min_amount`, `image`)
							VALUES ( '" . $name . "', '" . $description . "','" . $price . "','" . $cost_price . "','" . $min_amount . "','" . $fileDestination . "' )";

					if(mysqli_query($conn, $sql)){
						move_uploaded_file($fileTmpName,$fileDestination);
						header('location: upload.php?message=המוצר עלה בהצלחה');
						exit;
					} else {
						header('location: upload.php?errorMessage=קיימת בעיה העלאת המוצר');
						exit;
					}
					
					move_uploaded_file($fileTmpName,$fileDestination);
					
				} else{
					header('location: upload.php?errorMessage=הקובץ צריך להיות עד 5 מגה בית ולא יותר ');
					exit;
				}

			} else {
				header("location: upload.php?errorMessage=קיימת בעיה בהעלאת התמונה");
				exit;
			}
		} else{
			header("location: upload.php?errorMessage=קבצים מהסוג הזה אימם מורשים");
			exit;
		}
				
					
	} else {
		$sql = "INSERT INTO products ( `name`, `description`, `price`, `cost_price`, `min_amount`, `image`)
				VALUES ( '" . $name . "', '" . $description . "','" . $price . "','" . $cost_price . "','" . $min_amount . "','' )";

		if(mysqli_query($conn, $sql)){
			header('location: upload.php?message=המוצר עלה בהצלחה');
			exit;
		} else {
			header('location: upload.php?errorMessage=קיימת בעיה העלאת המוצר');
			exit;
		}
	} 
}





								


	


?>


