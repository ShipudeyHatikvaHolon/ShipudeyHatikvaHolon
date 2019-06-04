<?php 
require_once 'configur.php';

include_once 'header.php';
$user = $_SESSION['id'];
$message = '';
if (!$user)
{
     echo '<script language="javascript">';
    echo 'alert("על מנת לבצע רכישת שוברים יש להרשם לאתר")';
    echo '</script>';
    
      echo '<script language="javascript">';
    echo 'location.href = "signin.php"';
    echo '</script>';
    
    exit;
} 

$userDetail = mysqli_query($conn ,"SELECT * FROM users WHERE user_id = $user"); 
	
		if ( mysqli_num_rows($userDetail) > 0) 
		{
		  $data = $userDetail->fetch_array();
		} else
			echo "Your search query doesn't match any data!";
			
?>


<html>

<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="vouchers.css" />
	
	<script src="vouchers.js"></script>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
</head>

<body>
<h1 style="text-align: center;">  <?php echo $data['name']?> תודה שבחרת לרכוש שוברים במסעדת שיפודי התקווה - חולון</h1>	</br>	</br>
	<h3 style="text-align: center;"> !פרטי הזמנת השוברים נקלטו במערכת , נתראה במסעדה    </h3>	</br>
	<img = "https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Smiley.svg/250px-Smiley.svg.png"> </img>

</body>

	
<?php

$date= date("Y-m-d") ;
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
            
		$cat = $_POST['treatment'];
	
}


if($cat==1)
{
    $addVouchers=15;
}
else
{
     $addVouchers=10;
}

if(!$cat) {
  header('location: vouchers.php?errorMessage=חובה לבחור סוג שובר');
  exit;
}


$sqlFind="SELECT * FROM vouchers WHERE user_id=$user and category_id= $cat";


  if(mysqli_num_rows(mysqli_query($conn,$sqlFind))==0)//new voucher
  {
    
    $sql1="INSERT INTO vouchers(user_id,category_id,purchase_date,vouchers_left) values ( '$user',' $cat','$date', $addVouchers)";
      if ($result=mysqli_query($conn,$sql1))
      {
      $message .=  "New record created successfully";

      } else {
          $message .=  "Error: " . $sql . "<br>" . $conn->error;
        echo $message;
        
      } 
  }  

  else//activate voucher
  {
  
      if($cat==1)
  {
      $addVouchers=15;
  }
  else
  {
      $addVouchers=10;
  }


    $sql1=" UPDATE vouchers SET vouchers_left= vouchers_left+$addVouchers, purchase_date='$date' WHERE user_id=$user and category_id= $cat ";
    
      if ($result=mysqli_query($conn,$sql1))
      {
      $message .=  "New record created successfully";

      } else {
          $message .=  "Error: " . $sql1 . "<br>" . $conn->error;
        echo $message;
        
      } 
      
      
  }


?>	
	
<?php require 'footer.php'?>


</html>
