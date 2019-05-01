<?php 



$user = $_SESSION['user_id'][$id];
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
	
$servername = "localhost:3306";
$username = "robiso";
$password = "rakmaccabi";
$dbname = "robiso_hatikva";
$message = "";

$conn = new mysqli($servername, $username, $password, $dbname);

 mysqli_set_charset($conn,"utf8"); 
if ($conn->connect_error) 
{
     die("Connection failed: " . $conn->connect_error);
} 
$userDetail = $conn->query("SELECT * FROM users WHERE user_id =$user"); 
	
		if ($userDetail->num_rows > 0) 
		{
		  $data = $userDetail->fetch_array();
		} else
			echo "Your search query doesn't match any data!";
			
?>


<html>

<head>

	<link rel="stylesheet" href="vouchers.css" />
	
	<script src="vouchers.js"></script>
	

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

$servername = "localhost:3306";
$username = "robiso";
$password = "rakmaccabi";
$dbname = "robiso_hatikva";
$message = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 
if($cat==1)
{
    $addVouchers=15;
}
else
{
     $addVouchers=10;
}



$sqlFind="SELECT * FROM voucher WHERE user_id=$user and category_id= $cat";


if(mysqli_num_rows(mysqli_query($conn,$sqlFind))==0)
{
  $sql1="INSERT INTO voucher(user_id,category_id,purchase_date,vouchers_left) values ( '$user',' $cat','$date', $addVouchers)";
	  if ($result=mysqli_query($conn,$sql1))
     {
    $message .=  "New record created successfully";

    } else {
        $message .=  "Error: " . $sql . "<br>" . $conn->error;
      echo $message;
      
    } 
}  

else
{
 
    if($cat==1)
{
    $addVouchers=15;
}
else
{
     $addVouchers=10;
}


  $sql1=" UPDATE voucher SET vouchers_left= vouchers_left+$addVouchers, purchase_date='$date' WHERE user_id=$user and category_id= $cat ";
	  if ($result=mysqli_query($conn,$sql1))
     {
    $message .=  "New record created successfully";

    } else {
        $message .=  "Error: " . $sql1 . "<br>" . $conn->error;
      echo $message;
      
    } 
    
    
}

mysqli_set_charset($conn,"utf8");
mysqli_query($conn,"set character_set_client='utf8'");
mysqli_query($conn,"set character_set_results='utf8'");
mysqli_query($conn ,"set collation_connection='utf8'");
mysqli_set_charset($conn,"utf8");

$sql = "SELECT * FROM category where id_category=$cat";
	$result = mysqli_query($conn, $sql);
	
	 while ($res=mysqli_fetch_array($result))
	{
	    $catName=$res['name'];
	    $catDescription=$res['description'];
	    $catPrice=$res['price'];
	     
	}


    
?>	
	



</html>
