<?php
require_once 'configur.php';
session_start();
if($_SESSION['admin'] !== true){
    header('Location: isadmin.php');
    exit;
}

$action = filter_input(INPUT_GET, 'action');

switch($action) {

	case 'tables':
		$sql = "SELECT count(id) countTables, createdAt FROM tableorders
						GROUP BY DAY(createdAt)";
		$result = mysqli_query($conn, $sql);

		if($result && mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
					$datas[] = $row;
			}
		}
		
	break;

	case 'money':
	// count of money per day
		$sql = "SELECT * FROM `order`";
		$result = mysqli_query($conn, $sql);
		$dataTime = [];

		if($result && mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
					$datas[] = $row;
			}

			foreach( $datas as $data ) {
				$month = date("m",strtotime($data['dateTime']));
				$year = date("Y",strtotime($data['dateTime']));

				$row = unserialize($data['contentOrder']);

				
				if(isset($dataTime[$year][$month]['total'])) {
					$dataTime[$year][$month]['total'] += (int) $row['count_money'];
				} else {
					$dataTime[$year][$month]['total'] = (int) $row['count_money'];
				}
			
			}

			// count of tables per day
	}
		
	break;

	default:
	$action = 'default';
		$sql = "SELECT * FROM products 
						WHERE amount < min_amount";
		$result = mysqli_query($conn, $sql);

		if($result && mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
						$amount_products[] = $row;
				}
		}

		$sql = "SELECT * FROM vegetables 
						WHERE amount < min_amount";
		$result = mysqli_query($conn, $sql);

		if($result && mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
						$amount_vegetables[] = $row;
				}
		}

		$sql = "SELECT * FROM sauces 
						WHERE amount < min_amount";
		$result = mysqli_query($conn, $sql);

		if($result && mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
						$amount_sauces[] = $row;
				}
		}

		$sql = "SELECT * FROM pitas 
						WHERE amount < min_amount";
		$result = mysqli_query($conn, $sql);

		if($result && mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
						$amount_pitas[] = $row;
				}
		}

}
require_once 'header_admin.php';

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
				direction: rtl;
		}

		h4 {
			float: right;
			padding: 10px;
			direction: rtl;
		}

	</style>
</head>

<body>
	<div class="container">    
    
		<h3>ניהול דוחות</h3>

		<div class="tabs">
			<div class=" <?php echo $action == 'tables' ? 'current' : '' ?> tab"><a href="reports&charts3.php?action=tables">שולחנות</a></div>
			<div class=" <?php echo $action == 'money' ? 'current' : '' ?> tab"><a href="reports&charts3.php?action=money">רווחים</a></div>
			<div class=" <?php echo $action == 'default' ? 'current' : '' ?> tab"><a href="reports&charts3.php">חוסרים</a></div>
		</div>

		<?php 

		 switch($action){

			case 'tables': 
				echo '<h3>שולחנות:</h3>';
			break;

					case 'money': 
						echo '<h3>רווחים:</h3>';
					break;

					default:

						if( !empty($amount_vegetables) || !empty($amount_sauces) || !empty($amount_pitas) || !empty($amount_products) ) {
							echo '<h3>חוסרים:</h3>';
						} else {
						echo '<h3>לא קיימים חוסרים</h3>';
						}
			}
		?>

		<div class="table-responsive">

			<?php switch($action):

				case 'tables': ?> 

					<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
							<thead>
								<tr>
										<th>תאריך</th>
										<th>כמות שולחנות</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($datas as $data) {
										echo '
												<tr>
														<td>'.date("d-m-Y",strtotime($data['createdAt']) ).'</td>
														<td>'.$data['countTables'].'</td>
												</tr>
										';	
									}
								?>
										
							</tbody>
						</table>

				<?php break; ?>

				<?php case 'money': ?>
					<?php if(!empty($dataTime) ):?>
					<?php foreach($dataTime as $year => $data): ?>
					<h3> <?php echo $year ?> </h3>
					<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
						<thead>
							<tr>
									<th>חודש</th>
									<th>כמות רווחים</th>
							</tr>
						</thead>
						<tbody>
							<?php
											foreach($data as $month => $dataMonth) {
													echo '
													<tr>
															<td>'.$month.'</td>
															<td>'.$dataMonth['total'].'&#8362;</td>
													</tr>
													';	
											}										
							?>
									
						</tbody>
					</table>
				<?php endforeach; ?>
				<?php endif; ?>
				<?php break; ?>
				
			<?php default: ?>

			<?php if(!empty($amount_products)): ?>
			<h4> מוצרים: </h4>
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
					<tr>
							<th>ID</th>
							<th>שם</th>
							<th>כמות נוכחית</th>
							<th>כמות מינימלית</th>
					</tr>
				</thead>
				<tbody>
					<?php
									foreach($amount_products as $amount_product) {
											echo '
											<tr>
													<td>'.$amount_product['product_id'].'</td>
													<td>'.$amount_product['name'].'</td>
													<td>'.$amount_product['amount'].'</td>
													<td>'.$amount_product['min_amount'].'</td>
											</tr>
											';	
									}										
					?>
			        
				</tbody>
			</table>
			<?php endif; ?>

			<?php if(!empty($amount_vegetables)): ?>
			<h4> ירקות: </h4>
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
					<tr>
							<th>ID</th>
							<th>שם</th>
							<th>כמות נוכחית</th>
							<th>כמות מינימלית</th>
					</tr>
				</thead>
				<tbody>
					<?php
									foreach($amount_vegetables as $amount_vegetable) {
											echo '
											<tr>
													<td>'.$amount_vegetable['id'].'</td>
													<td>'.$amount_vegetable['name'].'</td>
													<td>'.$amount_vegetable['amount'].'</td>
													<td>'.$amount_vegetable['min_amount'].'</td>
											</tr>
											';	
									}										
					?>
			        
				</tbody>
			</table>
			<?php endif; ?>

			<?php if(!empty($amount_sauces)): ?>
			<h4> רטבים: </h4>
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
					<tr>
							<th>ID</th>
							<th>שם</th>
							<th>כמות נוכחית</th>
							<th>כמות מינימלית</th>
					</tr>
				</thead>
				<tbody>
					<?php
									foreach($amount_sauces as $amount_sauce) {
											echo '
											<tr>
													<td>'.$amount_sauce['id'].'</td>
													<td>'.$amount_sauce['name'].'</td>
													<td>'.$amount_sauce['amount'].'</td>
													<td>'.$amount_sauce['min_amount'].'</td>
											</tr>
											';	
									}										
					?>
			        
				</tbody>
			</table>
			<?php endif; ?>

			<?php if(!empty($amount_pitas)): ?>
			<h4> לחם: </h4>
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
					<tr>
							<th>ID</th>
							<th>שם</th>
							<th>כמות נוכחית</th>
							<th>כמות מינימלית</th>
					</tr>
				</thead>
				<tbody>
					<?php
									foreach($amount_pitas as $amount_pita) {
											echo '
											<tr>
													<td>'.$amount_pita['id'].'</td>
													<td>'.$amount_pita['name'].'</td>
													<td>'.$amount_pita['amount'].'</td>
													<td>'.$amount_pita['min_amount'].'</td>
											</tr>
											';	
									}										
					?>
			        
				</tbody>
			</table>
			<?php endif; ?>
		<?php endswitch; ?>

		</div>

	</div>

</body>

</html>	
