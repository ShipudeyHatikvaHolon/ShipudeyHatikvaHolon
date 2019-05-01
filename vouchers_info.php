<?php

session_start();

?>



<html lang="he">
	<head>
		<meta charset="UTF-8">
		
	</head>	
	
	<body>
		
		<?php 
	
$connect = mysqli_connect('localhost:3306', 'robiso', 'rakmaccabi', 'robiso_hatikva');
		
mysqli_set_charset($connect,"utf8");
	   $q = intval($_GET['id_category']);
	$query = "SELECT * FROM category where id_category = '$q'";	
	$result = mysqli_query($connect, $query);
	

if ($result->num_rows > 0) {
   
	

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