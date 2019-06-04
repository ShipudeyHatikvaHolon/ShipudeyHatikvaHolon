<?php
session_start();
if($_SESSION['admin'] !== true){
    header('Location: isadmin.php');
}
?>


<?php require_once 'header.php';
require_once 'configur.php';

$query = "SELECT * FROM products ORDER BY product_id ASC";
$result = mysqli_query($conn, $query);

?>	


<html>
	
	
	
	<head>
		
	<meta charset="UTF-8">
	
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
          <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>            
		
		<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">	
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="inventory.css"/>	
	<script src="tabledit/jquery.tabledit.js"></script>
	
	
	<style>
		
		table td{
			font-size: 14px;
			overflow: hidden;
		}	
		
		.glyphicon{
			padding:2px;
		}
		
		thead tr th{
			text-align: center;
		}
	</style>
	</head>
	
	<body>
	<div class="container">
	 <div class="table-responsive">  
	<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
		<thead>
			<tr>
				<th>ID</th>
				<th>שם</th>
				<th>תיאור</th>
				<th>מחיר</th>
				<th>כמות מינימלית</th>
				<th>כמות זמינה</th>
				<th>פעולות</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while($row = mysqli_fetch_array($result)){
				echo '
				<tr>
				<td>'.$row["product_id"].'</td>
				<td>'.$row["name"].'</td>
				<td>'.$row["description"].'</td>
				<td>'.$row["price"].'</td>
				<td>'.$row["min_amount"].'</td>
				<td>'.$row["amount"].'</td>
				</tr>
				';
			}
			?>
		</tbody>
	</table>
		</div>
	</div>


					
			
						
	</body>
	
		<script>
	$(document).ready(function(){  
     $('#editable_table').Tabledit({
      url:'mlay.php',
      columns:{
       identifier:[0, "id"],
       editable:[[1, 'name'], [2, 'description'], [3, 'price'], [4, 'min_amount'], [5, 'amount']]
      },
      restoreButton:false,
      onSuccess:function(data, textStatus, jqXHR)
      {
       if(data.action == 'delete')
       {
        $('#'+data.id).remove();
       }
      }
     });
 
});  
</script>
			
	
	
	
</html>

