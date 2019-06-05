<?php
require_once 'configur.php';
session_start();
if($_SESSION['admin'] !== true){
		header('Location: isadmin.php');
		exit;
}

$action = filter_input(INPUT_GET, 'action');

$products = [];
$id = filter_input(INPUT_GET, 'id');

$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
$min_amount = filter_input(INPUT_GET, 'min_amount', FILTER_VALIDATE_INT);
$amount = filter_input(INPUT_GET, 'amount', FILTER_VALIDATE_INT); 

switch($action) {
		case 'delete':

			if(!is_numeric($id)) {
				header('location: saucesAdmin.php');
				exit;
			}

			$sql = "DELETE FROM sauces WHERE id = " . $id;
			$result = mysqli_query($conn, $sql);

			if($result) {
				header('location: saucesAdmin.php?message=המוצר נמחק בהצלחה');
			} else {
				header('location: saucesAdmin.php?errorMessage=קרתה תקלה במחיקת המוצר');
			}
			exit;


		break;

		case 'edit':
			
		if(!is_numeric($id)) {
			header('location: saucesAdmin.php');
			exit;
		}

			$sql = "SELECT * FROM sauces WHERE id = " . $id;
			$result = mysqli_query($conn, $sql);

			if($result && mysqli_num_rows($result) > 0) {
				$product = mysqli_fetch_assoc($result);
			}
			
		break;

		case 'saveEdit':			

			if(!$name) {
				header('Location: saucesAdmin.php?errorMessage=שם המוצר הוא שדה חובה');
				exit;
			}

			if(!$min_amount) {
				header('Location: saucesAdmin.php?errorMessage=כמות מינימלית של המוצר הוא שדה חובה');
				exit;
			}

			if(!$amount) {
				header('Location: saucesAdmin.php?errorMessage=כמות המוצר הוא שדה חובה');
				exit;
			}

			$name = mysqli_real_escape_string($conn, $name);

			$sql = "UPDATE sauces SET
								`name` = '$name',
								`amount` = '$amount',
								`min_amount` = '$min_amount'
								 WHERE id = " . $id;


			$result = mysqli_query($conn, $sql);
			
			if( $result ) {
				header('Location: saucesAdmin.php?message=המוצר עודכן בהצלחה');
			}else {
				header('Location: saucesAdmin.php?errorMessage=קרתה בעיה בעדכון המוצר, אנא נסה שוב מאוחר יותר');
			}
			exit;

		break;
		
		case 'saveNew':

			if(!$name) {
				header('Location: saucesAdmin.php?errorMessage=שם המוצר הוא שדה חובה');
				exit;
			}

			if(!$min_amount) {
				header('Location: saucesAdmin.php?errorMessage=כמות מינימלית של המוצר הוא שדה חובה');
				exit;
			}

			if(!$amount) {
				header('Location: saucesAdmin.php?errorMessage=כמות המוצר הוא שדה חובה');
				exit;
			}

			$name = mysqli_real_escape_string($conn, $name);

			$sql = "INSERT INTO sauces (id, `name`, amount, min_amount )
													VALUES('', '$name', '$amount', '$min_amount' )";

			$result = mysqli_query($conn, $sql);
						
			if( $result ) {
				header('Location: saucesAdmin.php?message=המוצר נשמר בהצלחה');
			}else {
				header('Location: saucesAdmin.php?errorMessage=קרתה בעיה בשמירת המוצר, אנא נסה שוב מאוחר יותר');
			}
			exit;

		break;

		default:

			$sql = "SELECT * FROM sauces";
			$result = mysqli_query($conn, $sql);
			
			if($result && mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$products[] = $row;
				}
			}
			
}	

?>

<?php
require_once 'header_admin.php';

?>

<?php

	switch($action):

		default: 
		?>
	<html>



<head>

	<meta charset="UTF-8">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="inventory.css" />
	<link href="css/admin.css" rel="stylesheet">
	<script src="tabledit/jquery.tabledit.js"></script>


	<style>
		table td {
			font-size: 14px;
			overflow: hidden;
		}

		.glyphicon {
			padding: 2px;
		}

		thead tr th {
			text-align: center;
		}
		
		h3{
		    padding:5px;
		    text-align:right;
		    margin-bottom:3%;
		}

	</style>
</head>

<body>
	<?php displayMessage(); ?>
	<div class="container">
			
	
	<div class="tabs">
			<div class="tab"><a href="vegetablesAdmin.php">ניהול תוספות</a></div>
			<div class="current tab"><a href="saucesAdmin.php">ניהול רטבים</a></div>
			<div class="tab"><a href="pitasAdmin.php">ניהול ארוחות</a></div>
			<div class="tab"><a href="upload.php">ניהול מוצרים</a></div>
	</div>		
	    
	    <h3>ניהול רטבים</h3>
		<div class="table-responsive">
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
					<tr>
						<th>ID</th>
						<th>שם</th>						
						<th> כמות מינימלית</th>
						<th> כמות</th>
						<th>עריכה | מחיקה </th>
					</tr>
				</thead>
				<tbody>
					<?php

				if(!empty($products)) {
					foreach($products as $product) {
						echo '
						<tr>
						<td>'.$product['id'].'</td>
						<td>'.$product['name'].'</td>
						<td>'.$product['min_amount'].'</td>
						<td>'.$product['amount'].'</td>
						<td> ' .
							'<button data-id="'.$product['id'].'" type="button" class="tabledit-edit-button btn btn-sm btn-default edit-button" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>
							<button data-id="'.$product['id'].'" type="button" class="delete-button tabledit-delete-button btn btn-sm btn-default" style="float: none;"><span class="glyphicon glyphicon-trash"></span></button>' .
						'</td>
						</tr>
						';	
					}
				}				

			?>
			
				</tbody>
			</table>
		</div>

		<div style="display: flex; justify-content: center;">
			<a class="btn btn-info" href="saucesAdmin.php?action=addNew"> הוסף רוטב חדש </a>
		</div>

	</div>

	<script>
		$('.edit-button').on('click', function() {
			var id = $(this).data('id');
			window.location.href = "saucesAdmin.php?action=edit&id=" + id;
		})

		$('.delete-button').on('click', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			var r = confirm('אתה בטוח שברצונך למחוק את מוצר מספר' + id + '?');

			if(r) {
				window.location.href = "saucesAdmin.php?action=delete&id=" + id;
			}

		})
	</script>

</body>

</html>


		<?php break; ?>

		<?php case 'addNew':
					case 'edit': ?>

		<?php 
			$title = is_numeric($id) ? 'עריכת רוטב' : 'הוספת מוצר לחנות המוצרים';
			$actionLink = is_numeric($id) ? 'saveEdit' : 'saveNew';
			$submit_name = is_numeric($id) ? 'שמור' : 'הוסף רוטב לחנות';
			
		?>
<!DOCTYPE html>
<html lng=he>
	<head>
		
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	
	


	<title>שיפודי התקווה</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">

		
		
		<style>
			body{
				background: #f1f1f1;
				font-family: calibri;
			}
			
			
			form{
				text-align: right;
				direction: rtl;
				padding: 10%;
				
			
				border-radius: 5%;
				margin-bottom: 10px;
				
			}
			input{
				margin-bottom: 5px;
				border: none;
				border-bottom: 1px solid #222;
				background: none;
				padding: 2px;
			}
			
			input[type="file"]{
				border:none;
				
			}
			
	

a {
  color:#7CBDBA;
  text-decoration: none;
}

.button {
  display: inline-block;
  line-height: 3em;
  padding: 0 1em;
  background: #3B3B47;
  border-radius: 0.125em;
  background-clip: padding-box;
	color:#f1f1f1;
  margin-right: 1em
}

.button:before {
    content: "\2190";
}

.button--plain {
	background: #41414E;
		
}
			input[type="file"]{
				color:blue;
				opacity: 0.6;
				margin: 15px;
				
			}
		.button--plain:hover{
			color:aqua;
			border:0.3px solid 	aqua;
		}
			

			
			h2{
				padding: 5px;
				text-align: center;
				margin-top: 5%;
				color:#3B3B47;
			}
			
			@media (max-width:576px){
				.button{
					position: relative;
					right:40px;
				}
			}
			
			
			#formContainer {
				direction: rtl;
				box-shadow: 2px 2px red;	
				margin: 0 auto;
				border: 3px double #41414e;
				box-shadow: -1px 4px 26px -1px rgba(65,65,78,0.65);
				background: #fafafa;
				margin-bottom:5%;
			}

			
		</style>
	</head>
	<body>
	<div class="container">
		<div id="formContainer" class="col-lg-8">
		 <h2><?php echo $title ?></h2>
		<form action="" method="get" enctype="multipart/form-data">
		<p>
			אנא מלא את כל הפרטים הבאים:
		</p> 
			שם מוצר: <input type="text" name="name" value="<?php echo $id ? $product['name'] : '' ?>"><br>
			כמות מינימלית: <input type="number" name="min_amount" value="<?php echo $id ? $product['min_amount'] : '' ?>"><br>
			כמות : <input type="number" name="amount" value="<?php echo $id ? $product['amount'] : '' ?>"><br>

			<input type="hidden" name="action" value="<?php echo $actionLink ?>"> 
			<?php if($action == 'edit'): ?>
			<input type="hidden" name="id" value="<?php echo $product['id'] ?>"> 
		<?php endif; ?>
			</label>
			<button class="button --plain" type="submit" name="submit"><?php $submit_name ?></button>
		</form>
		</div>
		</div>
	</body>
</html>

	<?php break; ?>


<?php endswitch; ?>
