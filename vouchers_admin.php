<?php
require_once 'configur.php';
session_start();
if($_SESSION['admin'] !== true){
		header('Location: isadmin.php');
		exit;
}

$action = filter_input(INPUT_GET, 'action');

      

$userName = filter_input(INPUT_GET, 'userName', FILTER_SANITIZE_STRING);
$userEmail = filter_input(INPUT_GET, 'userEmail', FILTER_SANITIZE_STRING);
$userPhone = filter_input(INPUT_GET, 'userPhone', FILTER_SANITIZE_STRING);
$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
$purchase_date = filter_input(INPUT_GET, 'purchase_date', FILTER_SANITIZE_STRING);
$vouchers_left = filter_input(INPUT_GET, 'vouchers_left', FILTER_VALIDATE_INT);


$products = [];
$catId = filter_input(INPUT_GET, 'catId');
$userId = filter_input(INPUT_GET, 'userId');

switch($action) {
		case 'delete':

			if( !is_numeric($catId) || !is_numeric($userId) ) {
				header('location: vouchers_admin.php');
				exit;
			}

			$sql = "DELETE FROM vouchers WHERE user_id = $userId AND category_id = $catId";
			$result = mysqli_query($conn, $sql);

			if($result) {
				header('location: vouchers_admin.php?message=השובר נמחק בהצלחה');
			} else {
				header('location: vouchers_admin.php?errorMessage=קרתה תקלה במחיקת השובר');
			}
			exit;


		break;

		case 'edit':

			if(!is_numeric($catId) || !is_numeric($userId)) {
				header('location: vouchers_admin.php');
				exit;
			}

			$sql = "SELECT vouchers.*, category.*, users.name as userName, users.email as userEmail, users.phone as userPhone  FROM vouchers
					JOIN category ON vouchers.category_id = category.id_category
					JOIN users on users.user_id = vouchers.user_id
					WHERE vouchers.user_id = $userId AND vouchers.category_id = $catId";

			$result = mysqli_query($conn, $sql);

			if($result && mysqli_num_rows($result) > 0) {
				$product = mysqli_fetch_assoc($result);
			}
			
		break;

		case 'saveEdit':
						

			$name = mysqli_real_escape_string($conn, $name);			

			$sql = "UPDATE vouchers SET
								`purchase_date` = '$purchase_date',
								`vouchers_left` = '$vouchers_left',
								`category_id` = '$category_id'
								 WHERE user_id = $userId AND category_id = $catId";

			$result = mysqli_query($conn, $sql);
			
			if( $result ) {
				header('Location: vouchers_admin.php?message=השובר עודכן בהצלחה');
			}else {
				header('Location: vouchers_admin.php?errorMessage=קרתה בעיה בעדכון השובר, אנא נסה שוב מאוחר יותר');
			}
			exit;

		break;
		
		default:

			$sql = "SELECT vouchers.*, category.*, users.name as userName, users.email as userEmail, users.phone as userPhone  FROM vouchers
					JOIN category ON vouchers.category_id = category.id_category
					JOIN users on users.user_id = vouchers.user_id";
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
	
	    <h3>ניהול שוברים</h3>
		<div class="table-responsive">
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
					<tr>
						<th>ID</th>
						<th>שם</th>						
						<th>מייל</th>		
						<th>פלאפון</th>		
						<th>מזהה שובר</th>		
						<th>סוג שובר</th>		
						<th>תאריך רכישה</th>		
						<th>שוברים שנותרו</th>		
						<th>עריכה | מחיקה </th>
					</tr>
				</thead>
				<tbody>
					<?php

				if(!empty($products)) {
					foreach($products as $product) {
						echo '
						<tr>
						<td>'.$product['user_id'].'</td>
						<td>'.$product['userName'].'</td>
						<td>'.$product['userEmail'].'</td>
						<td>'.$product['userPhone'].'</td>
						<td>'.$product['id_category'].'</td>
						<td>'.$product['name'].'</td>
						<td>'.$product['purchase_date'].'</td>
						<td>'.$product['vouchers_left'].'</td>
						
						<td> ' .
							'<button data-catid="'.$product['id_category'].'" data-userid="'.$product['user_id'].'" type="button" class="tabledit-edit-button btn btn-sm btn-default edit-button" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>
							<button data-catid="'.$product['id_category'].'" data-userid="'.$product['user_id'].'" type="button" class="delete-button tabledit-delete-button btn btn-sm btn-default" style="float: none;"><span class="glyphicon glyphicon-trash"></span></button>' .
						'</td>
						</tr>
						';	
					}
				}				

			?>
			
				</tbody>
			</table>
		</div>

	</div>

	<script>
		$('.edit-button').on('click', function() {
			var userId = $(this).data('userid');
			var catId = $(this).data('catid');
			window.location.href = "vouchers_admin.php?action=edit&userId=" + userId + '&catId=' + catId;
		})

		$('.delete-button').on('click', function(e) {
			e.preventDefault();
			var userId = $(this).data('userid');
			var catId = $(this).data('catid');

			var r = confirm('אתה בטוח שברצונך למחוק את השובר  ?');

			if(r) {
				window.location.href = "vouchers_admin.php?action=delete&userId=" + userId + '&catId=' + catId;
			}

		})
	</script>

</body>

</html>


		<?php break; ?>

		<?php 
					case 'edit': ?>

		<?php 
			$title = ( is_numeric($catId) && is_numeric($userId) ) ? 'עריכת שובר' : 'הוספת שובר';
			$actionLink = ( is_numeric($catId) && is_numeric($userId) ) ? 'saveEdit' : 'saveNew';
			$submit_name = ( is_numeric($catId) && is_numeric($userId) ) ? 'שמור' : 'הוסף שובר לחנות';
			
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
		<?php switch($action): 
			 case 'edit': ?>
			מזהה שובר : <input type="text" name="category_id" value="<?php echo ($catId && $userId) ? $product['category_id'] : '' ?>"><br>
			תאריך רכישה : <input type="text" name="purchase_date" value="<?php echo ($catId && $userId) ? $product['purchase_date'] : '' ?>"><br>
			שוברים שנותרו : <input type="text" name="vouchers_left" value="<?php echo ($catId && $userId) ? $product['vouchers_left'] : '' ?>"><br>
		<?php break; endswitch; ?>

			<input type="hidden" name="action" value="<?php echo $actionLink ?>"> 
			<input type="hidden" name="userId" value="<?php echo $product['user_id'] ?>">
			<input type="hidden" name="catId" value="<?php echo $product['category_id'] ?>"> 
			</label>
			<button class="button --plain" type="submit" name="submit"><?php $submit_name ?></button>
		</form>
		</div>
		</div>
	</body>
</html>

	<?php break; ?>


<?php endswitch; ?>
