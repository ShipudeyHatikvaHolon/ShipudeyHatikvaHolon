<?php
require_once 'configur.php';
session_start();
$connect = $conn;
?>

<html lang="he">
	<head>
		<meta charset="UTF-8">
		
		<style>
			form{
				direction: rtl;
			}
			.title{
				font-weight: bold;
			}
		
			.description{
				font-size: 16px;
				color:#483D8B;
			}
		</style>
	</head>	
	
	<body>
		
		<?php 
	
		
mysqli_set_charset($connect,"utf8");
	   $q = intval($_GET['id_category']);
	$query = "SELECT * FROM category where id_category = '$q'";	
	$result = mysqli_query($connect, $query);
	

if ($result->num_rows > 0) {
    // output data of each row
	

    while($row = $result->fetch_assoc()) {
        echo "<span class='title'>  <br>תיאור: </span> " . "<span class='description'>" .$row["description"] . " </span> <br>";
		echo "<br>";
		echo "<span class='title'>  <br>מחיר: </span> " . "<span class='description'>" .$row["price"] . " &#8362; </span> <br>";
		
    }
} else {
    echo "0 results";
}


?>
		
	</body>
</html>
