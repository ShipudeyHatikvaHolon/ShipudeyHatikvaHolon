<?php
require_once 'configur.php';
session_start();
if($_SESSION['admin'] !== true){
    header('Location: isadmin.php');
    exit;
}

$action = filter_input(INPUT_POST, 'action');
if(!$action) {
    $action = filter_input(INPUT_GET, 'action');
}
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

switch($action) {

    case 'viewOrderDetails':

        if( !$id ) {
            header('Location: orders_admin.php');
            exit;
        }

        $title = 'הזמנה מספר ' . $id;
        $sql = 'SELECT * FROM `order`
                WHERE id = ' . $id;
        $result = mysqli_query($conn, $sql);

        if($result && mysqli_num_rows($result) > 0) {
            $order = mysqli_fetch_assoc($result);
        }
        
        if(empty($order)) {
            header('location: orders_admin.php');
            exit;
        }

        $order_details = unserialize($order['contentOrder']);
        $count_money = $order_details['count_money'];
        unset($order_details['count_money']);
    break;

    case 'deleteOrder':
        if( !$id ) {
            header('Location: orders_admin.php');
            exit;
        }
        $sql = 'DELETE FROM `order` WHERE id = ' . $id;
        $result = mysqli_query($conn, $sql);

        if($result) {
            header('location: orders_admin.php?message=ההזמנה נמחקה בהצלחה');
        } else {
            header('location: orders_admin.php?errorMessage=קרתה תקלה במחיקת ההזמנה, אנא נסה שוב מאוחר יותר');
        }

        exit;

    break;

    case 'edit':
        
        if( !$id ) {
            header('Location: orders_admin.php');
            exit;
        }
        $title = 'עריכת הזמנה';

        $sql = "SELECT * FROM `order` WHERE id = " . $id;
        $result = mysqli_query($conn, $sql);
        
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $order = $row;
            }
        }

        $order_details = unserialize($order['contentOrder']);

        // get all products
        $sql = "SELECT `name`, `product_id`, `price` FROM products";
        $result = mysqli_query($conn, $sql);

        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }

        // get all vegetables
        $sql = "SELECT * FROM adds";
        $result = mysqli_query($conn, $sql);

        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $vegetables[] = $row;
            }
        }

        // get all sauces
        $sql = "SELECT * FROM sauces";
        $result = mysqli_query($conn, $sql);

        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $sauces[] = $row;
            }
        }

         // get all pitas
         $sql = "SELECT * FROM pitas";
         $result = mysqli_query($conn, $sql);
 
         if($result && mysqli_num_rows($result) > 0) {
             while($row = mysqli_fetch_assoc($result)) {
                 $pitas[] = $row;
             }
         }

        $count_money = $order_details['count_money'];
        unset($order_details['count_money']);

        // count
        $_SESSION['saucesCountBeforeEdit'] = []; 
        $_SESSION['vegetablesCountBeforeEdit'] = []; 
        $_SESSION['pitasCountBeforeEdit'] = [];

        foreach($order_details as $data) {
           
            if( !empty($data['sauces']) ) {
                for( $i = 0; $i < count($data['sauces']); $i++ ) {
                    if( in_array($data['sauces'][$i]["sauce_$i"]['name'] ,$_SESSION['saucesCountBeforeEdit']) ) {
                        $_SESSION['saucesCountBeforeEdit'][$data['sauces'][$i]["sauce_$i"]['id']] += $data['quantity'];
                    } else {
                        $_SESSION['saucesCountBeforeEdit'][$data['sauces'][$i]["sauce_$i"]['id']] = $data['quantity'];
                    }
                }
            }

            if( !empty($data['vegetables']) ) {
                for( $i = 0; $i < count($data['vegetables']); $i++ ) {
                    if( in_array($data['vegetables'][$i]["vegetable_$i"]['name'] ,$_SESSION['vegetablesCountBeforeEdit']) ) {
                        $_SESSION['vegetablesCountBeforeEdit'][$data['vegetables'][$i]["vegetable_$i"]['id']] += $data['quantity'];
                    } else {
                        $_SESSION['vegetablesCountBeforeEdit'][$data['vegetables'][$i]["vegetable_$i"]['id']] = $data['quantity'];
                    }
                }
            }

            if( !empty($data['pita']) ) {
                $inArray = false;

                if(!empty($_SESSION['pitasCountBeforeEdit'])) {
                    for($i = 0; $i < count($_SESSION['pitasCountBeforeEdit']); $i++ ) {
                        if( in_array($data['pita'] ,$_SESSION['pitasCountBeforeEdit'][$i]) ) {
                            $inArray = true;
                            $_SESSION['pitasCountBeforeEdit'][$i]['count'] += $data['quantity'];
                            break;
                        } 
                    }
                }

                if( !$inArray ) {
                    $_SESSION['pitasCountBeforeEdit'][] = ['name'=> $data['pita'], 'count' => $data['quantity']];
                }
            }
            
        }

        

        
    break;

    case 'saveOrder':
            $row = filter_input(INPUT_POST, 'rows'); 
            $orderId = filter_input(INPUT_POST, 'orderId');
            $address = filter_input(INPUT_POST, 'address'); 

            $contactName = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'contactName'));
            $city = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'city'));
            $floor = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'floor'));
            $apartment = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'apartment'));
            $entry = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'entry'));
            $phone = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'phone'));
            $deliverNote = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'deliverNote'));

            $order_array = [];
            $order_array['count_money'] = 0;

            $countPitas = [];
            $countSouces = [];
            $countVegetables = [];

            for( $i = 0; $i < $row; $i++ ) {
                $id = filter_input(INPUT_POST, "id$i");
                $name = filter_input(INPUT_POST, "name$i");
                $price = filter_input(INPUT_POST, "price$i", FILTER_VALIDATE_FLOAT);
                $pita = filter_input(INPUT_POST, "pita$i");
                $pita_id = filter_input(INPUT_POST, "pitaId$i");
                $vegetables = filter_input(INPUT_POST, "vegetables{$i}0");
                $sauces = filter_input(INPUT_POST, "sauces{$i}0");
                $quantity = filter_input(INPUT_POST, "quantity$i", FILTER_VALIDATE_INT);
                $notes = filter_input(INPUT_POST, "notes$i");
                
                $order_array[$i]['id'] = $id;
                $order_array[$i]['name'] = $name;
                $order_array[$i]['price'] = $price;
                $order_array[$i]['notes'] = trim($notes);
                $order_array[$i]['pita'] = $pita;

                // count pitas
                if( !isset($countPitas[$pita_id]) ) {
                    $countPitas[$pita_id] = ['name' => $pita, 'count' => $quantity];
                } else {
                    $countPitas[$pita_id]['count'] += $quantity;
                }

                // count sauces
                if(!empty($sauces)) {
                    $order_array[$i]['sauces'] = [];
                    $j = 0;
                    while( $sauceName = filter_input(INPUT_POST, "sauces{$i}{$j}") ) {
                        
                        $sauceId = filter_input(INPUT_POST, "saucesId{$i}{$j}");
                        $order_array[$i]['sauces'][]["sauce_$j"] = [ 'name' => $sauceName, 'id' => (int) $sauceId ];

                        if( in_array($sauceName, $countSouces) ) {
                            $countSouces[$sauceId] += $quantity;
                        } else {
                            $countSouces[$sauceId] = $quantity;
                        }

                        $j++;
                    }
                }

                // count adds
                if(!empty($vegetables)) {
                    $order_array[$i]['vegetables'] = [];
                    $j = 0;
                    while($vegetableName = filter_input(INPUT_POST, "vegetables{$i}{$j}") ) {

                        $vegetableId = filter_input(INPUT_POST, "vegetablesId{$i}{$j}");
                        $order_array[$i]['vegetables'][]["vegetable_$j"] = [ 'name' => $vegetableName, 'id' => (int) $vegetableId ];

                        if( in_array($vegetableName, $countVegetables) ) {
                            $countVegetables[$vegetableId] += $quantity;
                        } else {
                            $countVegetables[$vegetableId] = $quantity;
                        }

                        $j++;
                    }
                }

                $order_array[$i]['quantity'] = trim($quantity);
                
                $order_array['count_money'] += $price * $quantity;
                 
            }

            $order_array_ser = serialize($order_array);
            $sql = "UPDATE `order`
                    SET contentOrder = '$order_array_ser',
                    `address` = '$address',
                    `contactName` = '$contactName',
                    `city` = '$city',
                    `floor` = '$floor',
                    `apartment` = '$apartment',
                    `entry` = '$entry',
                    `phone` = '$phone',
                    `deliverNote` = '$deliverNote'
                    WHERE id = $orderId";

            $result = mysqli_query($conn, $sql);
            
            if($result) {
                
                if( !empty($countPitas) ) {
                    $pitasIds = array_keys($countPitas);
                    
                    $sql = "UPDATE pitas SET amount = CASE `id` ";
                    
                    for ($i = 0; $i < count($pitasIds); $i++) {
                        $amount = $_SESSION['pitasCountBeforeEdit'][$i]['count'] - $countPitas[$pitasIds[$i]]['count'];
                        $operator = '+';
                        
                        if($amount < 0) {
                            $amount = abs($amount);
                            $operator = '-';
                        }
                        
                        $sql .= " WHEN '{$pitasIds[$i]}' THEN (pitas.amount $operator '$amount' )";
                    }
                    $sql .= 'ELSE pitas.amount END';
                    
                    $result = mysqli_query($conn, $sql);
                    
                }           

                if( !empty($countSouces) ) {
                    $souceIds = array_keys($countSouces);

                    $sql = "UPDATE sauces SET amount = CASE `id` ";
                    for ($i = 0; $i < count($souceIds); $i++) {
                        $amount = $_SESSION['saucesCountBeforeEdit'][$souceIds[$i]] - $countSouces[$souceIds[$i]];
                        $operator = '+';
                        
                        if($amount < 0) {
                            $amount = abs($amount);
                            $operator = '-';
                        }
                        
                        $sql .= " WHEN '{$souceIds[$i]}' THEN (sauces.amount $operator '$amount' )";
                    }
                    $sql .= 'ELSE sauces.amount END';
                    $result = mysqli_query($conn, $sql);
                }
                
                if( !empty($countVegetables) ) {
                    $vegetableIds = array_keys($countVegetables);

                    $sql = "UPDATE adds SET amount = CASE `id` ";
                    for ($i = 0; $i < count($vegetableIds); $i++) {
                        $amount = $_SESSION['vegetablesCountBeforeEdit'][$vegetableIds[$i]] - $countVegetables[$vegetableIds[$i]];
                        $operator = '+';
                        
                        if($amount < 0) {
                            $amount = abs($amount);
                            $operator = '-';
                        }
                        
                        $sql .= " WHEN '{$vegetableIds[$i]}' THEN (adds.amount $operator '$amount' )";
                    }
                    $sql .= 'ELSE adds.amount END';
                    $result = mysqli_query($conn, $sql);
                }

                header('location: orders_admin.php?message=ההזמנה עודכנה בהצלחה');
            }else {
                header('location: orders_admin.php?errorMessage=קרתה תקלה בשמירת ההזמנה');
            }

            exit;

    break;
        
    default:
        $title = 'ניהול הזמנות משלוחים';
        $sql = "SELECT * FROM `order` ORDER BY id DESC";
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
            position: relative;
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
        
        .order-contact-details h3 {
            margin-bottom: 0px;
        }

        .clear,
        .plus {
            position: absolute;
            left: 0px;
            cursor: pointer;
        }

        .plus {
            transform: rotate(45deg);
        }

        .plus.add-row {
            float: right;
            position: unset;
        }

        table td select:nth-child(3), td .clear:nth-child(2) {
            margin-top: 20px;
        }
        

	</style>
</head>

<body>
	<div class="container">    
        <?php displayMessage() ?>
        <div class="tabs">
            <div class="tab"><a href="orders_tables_admin.php">הזמנות של שולחנות</a></div>
            <div class="current tab"><a href="orders_admin.php">הזמנות של משלוחים</a></div>
		</div>

    
        <h3><?php echo $title ?></h3>
        
        <?php if($action == 'viewOrderDetails'): ?>
            <div style="display: flex; justify-content: center;">
                <a class="btn btn-info" href="orders_admin.php"> חזור לניהול הזמנות משלוחים </a>
            </div>
            <?php 
                endif; 
            ?>
    
		<div class="table-responsive">
            <?php if($action == 'edit') echo '<form method="POST" action="">'; ?>
			<table id="editable_table" class="table table-bordered table-striped" style="direction:rtl;">
				<thead>
                    <?php
                        switch($action): 
                        case 'viewOrderDetails': 
                    ?>
                        <tr>
                            <th>מספר הזמנה</th>
                            <th>זמן קבלת ההזמנה</th>
                            <th>שם המוצר</th>
                            <th>מחיר המוצר</th>
                            <th>סוג לחם</th>
                            <th>רטבים</th>
                            <th>סלטים</th>
                            <th>כמות</th>
                            <th>הערות</th>
                        </tr>

                    <?php
                        break;
                        
                       
                        case 'edit': ?>
                        <tr>
                            <th>שם המוצר</th>
                            <th>מחיר המוצר</th>
                            <th>סוג לחם</th>
                            <th>רטבים</th>
                            <th>סלטים</th>
                            <th>כמות</th>
                            <th>הערות</th>
                        </tr>
                        
                    <?php break;

                        default:
                    ?>

                        <tr>
                            <th>מספר הזמנה</th>
                            <th>זמן קבלת ההזמנה</th>
                            <th>פרטי ההזמנה</th>
                            <th>מחיקה | עריכה</th>
                        </tr>
                    <?php endswitch; ?>
				</thead>
				<tbody>
                    <?php
                    
                        switch($action): 
                            case 'viewOrderDetails':
                            if(!empty($order_details)) {
                                
                                foreach($order_details as $data) {
                                    $str = '
                                        <tr> 
                                            <td>'.$order['id'].'</td>
                                            <td>'.$order['dateTime'].'</td>
                                            <td>'.$data['name'].'</td>
                                            <td>'.$data['price'].'</td>
                                            <td>'.$data['pita'].'</td> ';

                                    if( !empty($data['sauces']) ) {

                                        $str .= '<td>';
                                        for( $i = 0; $i < count($data['sauces']); $i++ ) {
                                            if( !empty($data['sauces'][$i]['sauce_'.$i]) ) {
                                                $str .= $data['sauces'][$i]['sauce_'.$i]['name'] . '<br>';
                                            }
                                        }
                                        $str .= '</td>';

                                    }else {
                                        $str .= '<td>ללא רטבים</td>';
                                    }

                                    if( !empty($data['vegetables']) ) {
                                        $str .= '<td>';
                                        for( $i = 0; $i < count($data['vegetables']); $i++ ) {
                                            if( !empty($data['vegetables'][$i]['vegetable_'.$i]) ) {
                                                $str .= $data['vegetables'][$i]['vegetable_'.$i]['name'] . '<br>';
                                            }
                                        }
                                        $str .= '</td>';

                                    }else {
                                        $str .= '<td>ללא סלטים</td>';
                                    }

                                    $str .= '<td>'.$data['quantity'].'</td>
                                            <td>'.$data['notes'].'</td>
                                        </tr>
                                    ';
                                    echo $str;	
                                }
                            }
                        break;

                        case 'edit': 
                            if(!empty($order_details)) {
                                $i = 0;
                                $count = count($order_details);
                                foreach($order_details as $data) {
                                    
                                    
                                    $str = '
                                        <tr> 
                                            <td> <img onclick="deleteRow(this)" style="cursor: pointer;" src="images/clear.svg" alt="clear">  <input class="id" type="hidden" name="id'.$i.'" value="'.$data['id'].'"> 
                                                <select class="product-name" name="name'.$i.'" value="'.$data['name'].'"> ';
                                            
                                                if( !empty($products) ): 
                                                    foreach ( $products as $product ): 
                                                        $str.= "<option " . ($product['name'] == $data['name'] ? 'selected' : '')  . "> {$product['name']} </option>";                        
                                                    endforeach;
                                                endif; 
                                            $pitaId = 0;
                                        $str .= ' </select> </td>
                                            <td> 
                                                <input class="price" type="text" name="price'.$i.'" value="'.$data['price'].'"> 
                                                <input disabled type="hidden" class="product-base-price" name="priceBase'.$i.'" value="'.$data['price'] .'">
                                            </td>
                                            <td> <select class="pita-name" name="pita'.$i.'" >';
                                            if(!empty($pitas)) {
                                                $indexOfCurrentPita = 0;
                                                foreach($pitas as $key => $pita) {
                                                    if($data['pita'] == $pita['name']) {
                                                         $pitaId = $pita['id'];
                                                         $indexOfCurrentPita = $key;
                                                    }
                                                    $str .= '<option '. ($data['pita'] == $pita['name'] ? 'selected': '') .' >'.$pita['name'].' </option>';
                                                }
                                            }
                                            $str .= '</select>
                                            <input class="id" type="hidden" name="pitaId'.$i.'" value="'.$pitaId.'">
                                            <input class="pita-price" type="hidden" name="pitaPrice'.$i.'" value="'.$pitas[$indexOfCurrentPita]['price'].'">
                                            </td> ';

                                            // sauces
                                        $str .= '<td> <img data-name="sauces" class="plus" src="images/plus.svg" alt="clear">';
                                        if( !empty($data['sauces']) ) {
                                            for( $j = 0; $j < count($data['sauces']); $j++ ) {
                                                if( !empty($data['sauces'][$j]['sauce_'.$j]) ) {
                                                    $str .= " <img data-el_name='sauces{$i}{$j}' class='clear' src='images/clear.svg' alt='clear'> <select class='sauce-name' name='sauces{$i}{$j}' >";
                                                    foreach($sauces as $sauce) {
                                                        if($sauce['name'] == $data['sauces'][$j]['sauce_'.$j]['name']) {
                                                            $selected = 'selected';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        $str .= "<option $selected >" . $sauce['name'] . '</option>';    
                                                    }
                                                    '</select>';
                                                    $str .= "<input type='hidden' name='saucesId{$i}{$j}' value='" . $data['sauces'][$j]['sauce_'.$j]['id'] . "'> <br>";
                                                }
                                            }
                                        }
                                        $str .= '</textarea> </td>';
                                        
                                        // vegetables
                                        $str .= '<td> <img data-name="vegetables" class="plus" src="images/plus.svg" alt="clear">';
                                        if( !empty($data['vegetables']) ) {
                                            for( $j = 0; $j < count($data['vegetables']); $j++ ) {
                                                if( !empty($data['vegetables'][$j]['vegetable_'.$j]) ) {
                                                    $str .= " <img data-el_name='vegetables{$i}{$j}' class='clear' src='images/clear.svg' alt='clear'> <select class='vegetable-name' name='vegetables{$i}{$j}' > ";
                                                    
                                                    foreach($vegetables as $vegetable) {

                                                        if($vegetable['name'] == $data['vegetables'][$j]['vegetable_'.$j]['name']) {
                                                            $selected = 'selected';
                                                        } else {
                                                            $selected = '';
                                                        }

                                                        $str .= "<option $selected >" . $vegetable['name'] . '</option>';    
                                                    }
                                                    
                                                    $str .= " </select> <input class='id' type='hidden' name='vegetablesId{$i}{$j}' value='" . $data['vegetables'][$j]['vegetable_'.$j]['id'] . "'> <br>";
                                                }       
                                            }
                                        }
                                        $str .= '</td>';


                                    $str .= '<td> <input style="width: 30px;" type="text" name="quantity'.$i.'" value=" '.$data['quantity'].'"> </td>
                                            <td>
                                                <textarea name="notes'.$i.'"> '.$data['notes'].'</textarea> 
                                            </td>  
                                        </tr>
                                    ';
                                    echo $str;	
                                    $i++;
                                }
                                echo '<input type="hidden" name="rows" value=" '.$i.'"> ';
                            }
                     default:
                    
                            if(!empty($orders)) {
                                foreach($orders as $order) {
                                    echo '
                                    <tr>
                                        <td>'.$order['id'].'</td>
                                        <td>'.$order['dateTime'].'</td>
                                        <td>  
                                            <a href="orders_admin.php?action=viewOrderDetails&id='.$order['id'].'" class="btn btn-info">פרטי ההזמנה</a>
                                        </td>
                                        <td> ' . 
                                            '<button data-id="'.$order['id'].'" type="button" class="delete-button tabledit-delete-button btn btn-sm btn-default" style="float: none;"><span class="glyphicon glyphicon-trash"></span></button> ' .
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

            <?php if($action == 'edit'): ?>
            <img data-name="row" class="plus add-row" src="images/plus.svg" alt="clear">
            <?php endif; ?>

            <?php if($action == 'edit'): echo '
                <div style="margin-top: 50px; direction: rtl; display: flex; flex-direction: column; align-items: flex-start; font-size: 20px;">
                
                <input type="hidden" name="orderId" value="'.$order['id'].'">
                <input type="hidden" name="action" value="saveOrder"> 
                ';
                
                include_once 'templates/deliversAddressForm.php'; 
            echo '
                <input class="btn btn-info" style="margin: 0 auto; display: block;" type="submit" name="submit" value="סיימתי">
                </div>
                </form>
            '; ?>
            <?php elseif($action == 'viewOrderDetails'): ?>
            <div class="order-contact-details">
                <h3>כתובת: <?php echo $order['address'] ?></h3>

                <h3>שם איש קשר: <?php echo $order['contactName'] ?></h3>
                <h3>עיר: <?php echo $order['city'] ?></h3>
                <h3>קומה: <?php echo $order['floor'] ?></h3>
                <h3>דירה: <?php echo $order['apartment'] ?></h3>
                <h3>כניסה: <?php echo $order['entry'] ?></h3>
                <h3>טלפון איש קשר: <?php echo $order['phone'] ?></h3>
                <h3>הערות לשליח: <?php echo $order['deliverNote'] ?></h3>
            <div>
                <br>
                <h3> סהכ הכל: <?php echo $count_money ?> ש"ח</h3>
                
            <?php endif; ?>
		</div>

	</div>

	<script>

        // get the data from php to javascript
        var json  = '<?php echo !empty($products) ? json_encode($products) : '' ?>';
        if(json) {
            var products = JSON.parse(json);
        }
        
        var json  = '<?php echo !empty($pitas) ? json_encode($pitas) : '' ?>';
        if(json) {
            var pitas = JSON.parse(json);
        }
        
        var json  = '<?php echo !empty($sauces) ? json_encode($sauces) : '' ?>';
        if(json) {
            var sauces = JSON.parse(json);
        }

        var json  = '<?php echo !empty($vegetables) ? json_encode($vegetables) : '' ?>';
        if(json) {
            var vegetables = JSON.parse(json);
        }

        $.each( $('.price'), function(key, val) {
            for(var i = 0; i < products.length; i++) {
                if(products[i].product_id == $(this).parents('tr').find('td input.id').val() ) {                    
                    if(products[i].price == $(this).parents('tr').find('td input.product-base-price').val() ) {
                        this.value = parseFloat(this.value) + parseFloat($(this.parentElement.parentElement).find('td .pita-price').val());         
                    } else {
                        break;
                    }
                }
            }
        } );
        

        $('.product-name').on('change', function() {            
            changeProduct(this, products);
        });

        $('.sauce-name').on('change', function() {
            changeSauce(this, sauces);
        });

        $('.vegetable-name').on('change', function() {
            changeVele(this, vegetables);
        });

        $('.pita-name').on('change', function() {
            changePita(this);
        });        

        $('.edit-button').on('click', function() {
			var id = $(this).data('id');
			window.location.href = "orders_admin.php?action=edit&id=" + id;
		});
		
		$('.delete-button').on('click', function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			var r = confirm('אתה בטוח שברצונך למחוק את הזמנה מספר' + id + '?');

			if(r) {
				window.location.href = "orders_admin.php?action=deleteOrder&id=" + id;
			}

		});

        $('td img.clear').on('click', function() {
            removeAdd(this);
        })
         
        $(' img.plus').on('click', function() {

                switch( $(this).data('name') ) {
                
                case 'vegetables':
                    createAdd('vegetables', 'vegetable', this, vegetables);
                break;

                case 'sauces':
                    createAdd('sauces', 'sauce', this, sauces);
                break;

                case 'row':
                    createRow(products, vegetables, sauces, pitas);
                break;

            }
        })

        function createAdd(names, name, _this, array) {
            var changeEvent = '';
            switch(name) {
                case 'vegetable':
                    changeEvent = 'onchange="changeVele(this, vegetables)"';
                break;

                case 'sauce':
                    changeEvent = 'onchange="changeSauce(this, sauces)"';
                break;
            }

            var content = '';
            
            var countVegetables = $(_this.parentElement).find('.'+name+'-name').length;          
            var tr =$('table tr');
            var index = 0;
            for(var j = 0; j < tr.length; j++) {
                if(_this.parentElement.parentElement == tr[j]) {
                    index--;
                    break;
                } 
                index++;
            }
            
            content += '<img onclick="removeAdd(this)"  data-el_name="'+names+index +countVegetables +'" class="clear" src="images/clear.svg" alt="clear"> <select '+changeEvent+' class="'+name+'-name" name="'+ names +index +countVegetables +'">';
            for(var i = 0; i < array.length; i++) {
                content += '<option> ' + array[i].name + ' </option>'   
            }
            content += '<input class="id" name="'+names +'Id'+index +countVegetables +'" type="hidden" value="'+array[0].id+'"> </select> <br>';
            $(_this.parentElement).append(content);
        }

        function removeAdd(_this) {
            var data_el_name = $(_this).data('el_name');
            $('[name=' + data_el_name + ']').remove();
            $(_this).remove();
        }

        function createRow(products, vegetables, sauces, pitas) {
            var input = $('input[name=rows]');
            var row = input.val().trim();
            input.val( parseInt(row)+1)
            
            var content = "";
            content += '<tr>'; 
            content +=      '<td> <img onclick="deleteRow(this)" style="position: unset;" class="clear" data-name="delete_row" src="images/clear.svg" alt="clear"> <input class="id" type="hidden" name="id'+row+'" value="'+products[0].id+'">';
            content +=          '<select onchange="changeProduct(this, products)" class="product-name" name="name'+row+'" > ';
                    
                        if( products.length ){ 
                            for ( var product in products ) {
                                content += '<option>' + products[product].name + '</option>';                        
                            }
                        }
                    
            content += ' </select> </td>';
            content +=        '<td> <input class="price" type="text" name="price'+row+'" value="'+ ( parseFloat(products[0].price) + parseFloat(pitas[0].price) )+'"> <input disabled class="product-base-price" type="hidden" name="priceBase'+row+'" value="'+products[0].price +'"> </td>';
            content +=        '<td> <select onchange="changePita(this)" class="pita-name" name="pita'+row+'">';
                    for (var pita in pitas) {
                        content += '<option>'+pitas[pita].name+' </option>';
                    }
            content += '</select>';
            content +=        '<input class="id" type="hidden" name="pitaId'+row+'" value="'+pitas[0].id+'">';
            content +=        '<input class="pita-price" type="hidden" name="pitaPrice'+row+'" value="'+pitas[0].price+'">'
            content +=        '</td> ';

            //         // sauces
            content += '<td> <img data-name="sauces" class="plus" src="images/plus.svg" alt="clear" onclick="addSauces(this)"> </td>';
            
            //     // vegetables
            content += '<td> <img data-name="vegetables" class="plus" src="images/plus.svg" alt="clear" onclick="addVege(this)" > </td>';

                content += '<td> <input style="width: 30px;" type="text" name="quantity'+row+'" value="1"> </td>';
                content +=    '<td>';
                content +=        '<textarea name="notes'+row+'"></textarea>'; 
                content +=    '</td>';  
                content += '</tr>';
            $('table').append(content);
        }

        function addVege(_this) {
            createAdd("vegetables", "vegetable", _this, vegetables);
        }

        function addSauces(_this) {
            createAdd("sauces", "sauce", _this, sauces);
        }

        function changeProduct(_this, products) {
            var val = _this.value;
            var parent = _this.parentElement;
            var pitaPrice = parseFloat( $(parent.parentElement).find('td .pita-price').val() );

            for(var i = 0; i < products.length; i++) {
                if( products[i]['name'] == val ) {
                    $(parent).next().find('input.price').val( pitaPrice + parseFloat( products[i]['price'] ) );
                    $(parent).find('input.id').val(products[i]['product_id'])
                    $(parent.parentElement).find('td input.product-base-price').val(products[i]['price'])
                }
            }
        }

        function changeVele(_this, vegetables) {
            var val = _this.value;
            
            for(var i = 0; i < vegetables.length; i++) {
                if( vegetables[i]['name'] == val ) {
                    var el = $(_this).next().val(vegetables[i]['id']);
                }
            }
        }

        function changeSauce(_this, sauces) {
            var val = _this.value;
            
            for(var i = 0; i < sauces.length; i++) {
                if( sauces[i]['name'] == val ) {
                    var el = $(_this).next().val(sauces[i]['id']);
                }
            }
        }

        function deleteRow(_this) {
            var input = $('input[name=rows]');
            input.val( parseInt(input.val()) - 1 );
            $(_this.parentElement.parentElement).remove();
        }

        function changePita(_this) {
            var val = _this.value;
            var parent = _this.parentElement;
            var poductId = $(parent.parentElement).find('td .id').val();

            for(var i = 0; i < pitas.length; i++) {
                if( pitas[i]['name'] == val ) {
                    $(parent).find('input.id').val(pitas[i]['id']);
                    $(parent).find('input.pita-price').val(pitas[i]['price']);
                    for(var j = 0; j < products.length; j++ ) {
                        if( poductId == products[j].product_id ) {
                            $(parent.parentElement).find('td .price').val( parseFloat(pitas[i]['price']) + parseFloat( products[j].price ) );
                            break;
                        }
                    }
                   break; 
                }
            }
        }

	</script>
</body>

</html>
	
