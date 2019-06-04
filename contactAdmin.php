<?php 
    require_once 'configur.php';

    session_start();
    if($_SESSION['admin'] !== true){
        header('Location: isadmin.php');
        exit;
    }

    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if($action == 'delete') {
        if(!is_numeric($id)) {
            header('location: contactAdmin.php');
            exit;
        }

        $sql = "DELETE FROM contacts WHERE id = " . $id;
        $result = mysqli_query($conn, $sql);

        if($result) {
            header('location: contactAdmin.php?message=ההודעה נמחקה בהצלחה');
        } else {
            header('location: contactAdmin.php?errorMessage=קרתה טקלה במחיקת ההודעה, אנא נסה שוב מאוחר יותר');
        }
        exit;
    }

    $sql = "SELECT * FROM contacts";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $contacts[] = $row;            
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
	    
	    
	    <h3>ניהול הודעות</h3>
		<div class="table-responsive">
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
					<tr>
						<th>ID</th>
						<th>נושא</th>
						<th>אימל</th>
						<th>תוכן ההודעה</th>
					</tr>
				</thead>
				<tbody>
					<?php

				if(!empty($contacts)) {
					foreach($contacts as $contact) {
						echo '
						<tr>
                            <td>'.$contact['id'].'</td>
                            <td>'.$contact['subject'].'</td>
                            <td>'.$contact['email'].'</td>
                            <td>'.$contact['content'].'</td>
                            <td> ' .
							'<button data-id="'.$contact['id'].'" type="button" class="delete-button tabledit-delete-button btn btn-sm btn-default" style="float: none;"><span class="glyphicon glyphicon-trash"></span></button>' .
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
        $('.delete-button').on('click', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			var r = confirm('אתה בטוח שברצונך למחוק את מוצר מספר' + id + '?');

			if(r) {
				window.location.href = "contactAdmin.php?action=delete&id=" + id;
			}

		})
    </script>
</body>

</html>
