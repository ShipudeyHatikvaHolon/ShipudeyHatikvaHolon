<?php
require_once 'configur.php';
session_start();
if($_SESSION['admin'] !== true){
    header('Location: isadmin.php');
    exit;
}

$action = filter_input(INPUT_GET, 'action');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

switch($action) {

    case 'deleteOrder':
        if( !$id ) {
            header('Location: orders_tables_admin.php');
            exit;
        }
        $sql = 'DELETE FROM tableorders WHERE id = ' . $id;
        $result = mysqli_query($conn, $sql);

        if($result) {
            header('location: orders_tables_admin.php?message=ההזמנה נמחקה בהצלחה');
        } else {
            header('location: orders_tables_admin.php?errorMessage=קרתה תקלה במחיקת ההזמנה, אנא נסה שוב מאוחר יותר');
        }

        exit;

    break;

    case 'edit':

        if(!$id) {
            header('location: orders_tables_admin.php');
            exit;
        }     

        $title = 'עריכת הזמנת שולחן';
        $sql = "SELECT * FROM tableorders WHERE id = '$id'";    
        $result = mysqli_query($conn, $sql);
        if($result && mysqli_num_rows($result) ) {
            $order = mysqli_fetch_assoc($result);
        }

        // get tables
        $sql = "SELECT * FROM `tables`";
        $result = mysqli_query($conn, $sql);
        if($result && mysqli_num_rows($result) > 0 ) {
            while($row = mysqli_fetch_assoc($result)) {
                $tables[] = $row;
            }
        }
    break;

    case 'saveNew':
        $datetime = filter_input(INPUT_GET, 'datetime');
        $table_name = filter_input(INPUT_GET, 'tableName');
        $name = filter_input(INPUT_GET, 'name');
        $phone = filter_input(INPUT_GET, 'phone');

        if(!empty($table_name) && !empty($table_name)) {
            $sql = "UPDATE tableorders SET
                tableName = '$table_name',
                `name` = '$name',
                phone = '$phone',
                `datetime` = '$datetime' 
                WHERE id = $id";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    header('location: orders_tables_admin.php?message=ההזמנת שולחן נשמרה בהצלחה');
                } else {
                    header('location: orders_tables_admin.php?errorMessage=קרתה תקלה בשמירת ההזמנה');
                }
                exit;
        }

    break;

    default:
        $title = 'ניהול הזמנות שולחנות';
        $sql = "SELECT * FROM tableorders  ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
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
	<div class="container">   
        <?php displayMessage() ?>
        <div class="tabs">
            <div class="current tab"><a href="orders_tables_admin.php">הזמנות של שולחנות</a></div>
            <div class="tab"><a href="orders_admin.php">הזמנות של משלוחים</a></div>
		</div>

    
        <h3><?php echo $title ?></h3>
        
        <?php if($action == 'viewOrderDetails'): ?>
            <div style="display: flex; justify-content: center;">
                <a class="btn btn-info" href="orders_tables_admin.php"> חזור לניהול הזמנות </a>
            </div>
    <?php endif; ?>

		<div class="table-responsive">
            <?php if($action == 'edit') echo '<form>' ?>
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
                    <tr>
                        <?php switch($action): 
                            case 'edit':
                            ?>
                            <th>זמן ביצוע ההזמנה</th>
                            <th>סוג שולחן</th>
                            <th> שם</th>
                            <th>פלאפון </th>

                            <?php break;
                             default: ?>
                            <th>מספר הזמנה</th>
                            <th>זמן קבלת ההזמנה</th>
                            <th>זמן ביצוע ההזמנה</th>
                            <th>סוג שולחן</th>
                            <th> שם</th>
                            <th>פלאפון </th>
                            <th>מחיקה</th>
                        <?php endswitch; ?>
                    </tr>
				</thead>
				<tbody>
                    <?php
                        switch($action): 
                        case 'edit':
                        
                            if(!empty($order)) {                            
                                    echo '
                                    <tr>
                                        <td> <input type="text" name="datetime" value="'.$order['datetime'].'" </td>
                                        <td> <select name="tableName" >';
                                        
                                        foreach($tables as $table) {
                                            if($table['name'] == $order['tableName']) {
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo "<option $selected> {$table['name']} </option>";
                                        }
                                        
                                        echo '</select></td>
                                        <td> <input type="text" name="name" value="'.$order['name'].'" </td>
                                        <td> <input type="text" name="phone" value="'.$order['phone'].'" </td>
                                    </tr>
                                    ';	
                            }	

                        break;
                        default:
                            if(!empty($orders)) {
                                foreach($orders as $order) {
                                    echo '
                                    <tr>
                                        <td>'.$order['id'].'</td>
                                        <td>'.$order['createdAt'].'</td>
                                        <td>'.$order['datetime'].'</td>
                                        <td>'.$order['tableName'].'</td>
                                        <td>'.$order['name'].'</td>
                                        <td>'.$order['phone'].'</td>
                                        <td> ' . 
                                            '<button data-id="'.$order['id'].'" type="button" class="delete-button tabledit-delete-button btn btn-sm btn-default" style="float: none;"><span class="glyphicon glyphicon-trash"></span></button>' .
                                            '<button data-id="'.$order['id'].'" type="button" class="tabledit-edit-button btn btn-sm btn-default edit-button" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>' .
                                        '</td>
                                    </tr>
                                    ';	
                                }
                            }	
                        endswitch;			
                    ?>
			        
				</tbody>
            </table>
            <?php if($action == 'edit') echo ' <input style="margin: 0 auto; display: block;" class="btn btn-info" type="submit" name="submit" value="סיימתי"> <input type="hidden" name="id" value="'. $order['id'] .'"> <input type="hidden" name="action" value="saveNew"> </form>' ?>
		</div>

	</div>

	<script>
		
		$('.delete-button').on('click', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			var r = confirm('אתה בטוח שברצונך למחוק את הזמנה מספר' + id + '?');

			if(r) {
				window.location.href = "orders_tables_admin.php?action=deleteOrder&id=" + id;
			}

		})

        $('.edit-button').on('click', function(e) {
			e.preventDefault();
			var id = $(this).data('id');

            window.location.href = "orders_tables_admin.php?action=edit&id=" + id;

		})
	</script>

</body>
</html>
	
