<?php 
require_once 'configur.php';
$connect = $conn;
include_once 'header.php';

$product_ids = array();
$action = filter_input(INPUT_GET, 'action');

$vegetables = [];
$sauces  = [];
$pitas  = [];

// get all vegetables
$sql = "SELECT * FROM adds";
$result = mysqli_query($conn, $sql);

if($result ) {
    while($row = mysqli_fetch_assoc($result)) {
        $vegetables[] = $row;
    }
}

// get all sauces
$sql = "SELECT * FROM sauces";
$result = mysqli_query($conn, $sql);

if($result ) {
    while($row = mysqli_fetch_assoc($result)) {
        $sauces[] = $row;
    }
}

// get all pitas
$sql = "SELECT * FROM pitas";
$result = mysqli_query($conn, $sql);

if($result ) {
    while($row = mysqli_fetch_assoc($result)) {
        $pitas[] = $row;
    }
}


//check if Add to Cart button has been submitted
if(filter_input(INPUT_POST, 'add_to_cart')){
    
	if( !isset($_SESSION['shopping_cart']) ) {
        $_SESSION['shopping_cart'] = [];
    }

     $count = count($_SESSION['shopping_cart']);	
     
     $product_ids = array_column($_SESSION['shopping_cart'], 'id');
		
		$_SESSION['shopping_cart'][$count] = array
        (
            'id' => filter_input(INPUT_GET, 'id'),
            'name' => filter_input(INPUT_POST, 'name'),
            'price' => filter_input(INPUT_POST, 'price'),
            'quantity' => filter_input(INPUT_POST, 'quantity'),
            'notes' => filter_input(INPUT_POST, 'notes'),
            'pita' => filter_input(INPUT_POST, 'pita'),
            'pita_price' => filter_input(INPUT_POST, 'pita_selected_price'),
        );        

        // get sauces
        // show in the cart the sauces you choose
        $countSauceIndex = 0;
        $sauce_count = filter_input(INPUT_POST, 'sauce_count', FILTER_VALIDATE_INT);
        if(!empty($sauce_count)) {
            for($i = 0; $i <= $sauce_count; $i++) {

                $sauceInput = filter_input(INPUT_POST, 'sauce_'. $i);

                if($sauceInput) {
                    $sauceInputId = filter_input(INPUT_POST, 'sauce_' . $i . '_id', FILTER_VALIDATE_INT);
                    

                    if($sauceInputId) {
                        $_SESSION['shopping_cart'][$count]['sauces'][$countSauceIndex] = [
                            'sauce_'. $countSauceIndex => ['name' => $sauceInput, 'id' => $sauceInputId]
                        ];
                        $countSauceIndex++;
                    }

                }else {
                    continue;
                }
            }
        }
        
        // get vegetables
        // show in the cart the vegetables you choose
        $countVegetableIndex = 0;
        $vegetable_count = filter_input(INPUT_POST, 'vegetable_count', FILTER_VALIDATE_INT);
        
        if(!empty($vegetable_count)) {
            for($i = 0; $i <= $vegetable_count; $i++) {
                
                $vegetableInput = filter_input(INPUT_POST, 'vegetable_'. $i);

                if($vegetableInput) {
                    $vegetableInputId = filter_input(INPUT_POST, 'vegetable_' . $i . '_id', FILTER_VALIDATE_INT);

                    if($vegetableInputId) {
                        $_SESSION['shopping_cart'][$count]['vegetables'][$countVegetableIndex] = [
                            'vegetable_'. $countVegetableIndex => ['name' => $vegetableInput, 'id' => $vegetableInputId]
                        ];
                        $countVegetableIndex++;
                    }

                }else {
                    continue;
                }
            }
        }
                
    // check duplicate orders
	for($i = 0; $i < $count; $i++) {
        if( !isset($_SESSION['shopping_cart'][$count]) ) {
            break;
        }

        $temp1 = $_SESSION['shopping_cart'][$i]['quantity'];
        $temp2 = $_SESSION['shopping_cart'][$count]['quantity'];

        unset($_SESSION['shopping_cart'][$count]['quantity']);
        unset($_SESSION['shopping_cart'][$i]['quantity']);
        
        if( $_SESSION['shopping_cart'][$count] == $_SESSION['shopping_cart'][$i] ) {
            $_SESSION['shopping_cart'][$i]['quantity'] = $temp1;

            $_SESSION['shopping_cart'][$i]['quantity']++;
            unset($_SESSION['shopping_cart'][$count]);
        }else {
            $_SESSION['shopping_cart'][$i]['quantity'] = $temp1;

            if( !empty($_SESSION['shopping_cart'][$count]) ) {
                $_SESSION['shopping_cart'][$count]['quantity'] = $temp2;
            }
        }
    }
	
};

if($action === 'delete'){
    $id = filter_input(INPUT_GET, 'id');
    unset($_SESSION['shopping_cart'][$id]);

    //reset session array keys so they match with $product_ids numeric array
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}

if($action == 'saveorder') {

    $ids_of_vegetables = []; // will contain the ids of vegetables and count them
    $ids_of_sauces = []; // will contain the ids of sauces and count them
    $ids_of_pitas = []; // will contain the ids of pitas and count them
    $count_money = 0;

    $address = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'address'));
    $contactName = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'contactName'));
    $city = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'city'));
    $floor = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'floor'));
    $apartment = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'apartment'));
    $entry = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'entry'));
    $phone = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'phone'));
    $deliverNote = mysqli_real_escape_string($conn, filter_input(INPUT_GET, 'deliverNote'));
    
    $params = "&address=$address&contactName=$contactName&city=$city&floor=$floor&apartment=$apartment&entry=$entry&phone=$phone&deliverNote=$deliverNote";

    // validation
    if(empty($address)) {
        header('location: deliveries.php?errorMessage=הכתובת הוא שדה חובה' . $params);
        exit;
    }

    if(empty($contactName)) {
        header('location: deliveries.php?errorMessage=שם האיש קשר הוא שדה חובה' . $params);
        exit;
    }

    if(empty($city)) {
        header('location: deliveries.php?errorMessage=העיר הוא שדה חובה' . $params);
        exit;
    }

    if(empty($floor) || !is_numeric($floor)) {
        header('location: deliveries.php?errorMessage=הקומה הוא שדה חובה וחייב להיות מספר' . $params);
        exit;
    }

    if(empty($phone)) {
        header('location: deliveries.php?errorMessage=הפלאפון של איש הקשר הוא שדה חובה' . $params);
        exit;
    }

    if(empty($entry)) {
        header('location: deliveries.php?errorMessage=הכניסה הוא שדה חובה' . $params);
        exit;
    }

    if(empty($apartment) || !is_numeric($apartment) ) {
        header('location: deliveries.php?errorMessage=הדירה הוא שדה חובה וחייב להיות מספר' . $params);
        exit;
    }

    // count the money
    foreach( $_SESSION['shopping_cart'] as $product) {
        $count_money += ( ((float)$product['price']) * $product['quantity'] ) + ( ((float)$product['pita_price']) * $product['quantity'] );
    }
    $_SESSION['shopping_cart']['count_money'] = $count_money;

    $order = serialize( $_SESSION['shopping_cart'] );
    $sql = "INSERT INTO `order` (contentOrder, `dateTime`, `address`, `contactName`, `city`, `floor`, `apartment`, `entry`, `phone`, `deliverNote` )    
            VALUES ('$order', NOW(), '$address', '$contactName', '$city', '$floor', '$apartment', '$entry', '$phone', '$deliverNote') ";

    $result = mysqli_query($conn, $sql);
   
    $url=strtok($_SERVER["REQUEST_URI"],'?');

    /**
     * 1. the new order was updated successfully
     * 2. count all of the order quantity
     * 3. update all of the PITAS, sauces, vegetables IN general ( in the Database )
     * 4. reset the cart
     * 5. 
     */

//  1
    if($result && mysqli_affected_rows($conn)) {
        
        // update amount of products
        // count vegetables

//      2
        foreach( $_SESSION['shopping_cart'] as $product ) {
            if(!empty($product['vegetables'])) {                
                for($i = 0; $i < count($product['vegetables']); $i++ ) {
                    
                    $in_array_vegetable = false;

                    foreach($ids_of_vegetables as $key => $array ) {
                        
                        if($array['id'] == $product['vegetables'][$i]['vegetable_'.$i]['id']) {
                            $in_array_vegetable = true;
                            $ids_of_vegetables[$key]['count'] += $product['quantity'];                            
                        }
                    }
                    
                    if( !$in_array_vegetable ) {
                        $ids_of_vegetables[] = ['id' => $product['vegetables'][$i]['vegetable_'.$i]['id'], 'count' =>  $product['quantity']];
                    } 
                }
            }

            // count sauces
            if(!empty($product['sauces'])) {                
                for($i = 0; $i < count($product['sauces']); $i++ ) {
                    
                    $in_array_sauce = false;

                    foreach($ids_of_sauces as $key => $array ) {
                        
                        if($array['id'] == $product['sauces'][$i]['sauce_'.$i]['id']) {
                            $in_array_sauce = true;
                            $ids_of_sauces[$key]['count'] += $product['quantity'];                            
                        }
                    }
                    
                    if( !$in_array_sauce ) {
                        $ids_of_sauces[] = ['id' => $product['sauces'][$i]['sauce_'.$i]['id'], 'count' =>  $product['quantity']];
                    } 
                }
            }

            // count pita
            if(!empty($product['pita'])) {                
                $in_array_pita = false;

                foreach($ids_of_pitas as $key => $array ) {
                    if($array['name'] == $product['pita']) {
                        $in_array_pita = true;
                        $ids_of_pitas[$key]['count'] += $product['quantity'];                            
                    }
                }
                
                if( !$in_array_pita ) {
                    $ids_of_pitas[] = ['name' => $product['pita'], 'count' =>  $product['quantity']];
                } 
            }

        }
        
//      3
        if( !empty($ids_of_pitas) ) {
            $sql = "UPDATE pitas SET amount = CASE `name` ";
            foreach($ids_of_pitas as $ids_of_pita) {
                $sql .= "WHEN '{$ids_of_pita['name']}' THEN (pitas.amount - '{$ids_of_pita['count']}' )";
            }
            $sql .= 'ELSE pitas.amount END';

            $result = mysqli_query($conn, $sql);
            
        }

        if( !empty($ids_of_sauces) ) {
            $sql = "UPDATE sauces SET amount = CASE `id` ";
            foreach($ids_of_sauces as $ids_of_sauce) {
                $sql .= "WHEN '{$ids_of_sauce['id']}' THEN (sauces.amount - '{$ids_of_sauce['count']}' )";
            }
            $sql .= 'ELSE sauces.amount END';

            $result = mysqli_query($conn, $sql);
            
        }

        if( !empty($ids_of_vegetables) ) {
            $sql = "UPDATE adds SET amount = CASE `id` ";
            foreach($ids_of_vegetables as $ids_of_vegetable) {
                $sql .= "WHEN '{$ids_of_vegetable['id']}' THEN (adds.amount - '{$ids_of_vegetable['count']}' )";
            }
            $sql .= 'ELSE adds.amount END';

            $result = mysqli_query($conn, $sql);
            
        }

//      4

        // update the amount of the products
        $sql = "UPDATE products
                SET amount = CASE product_id ";
        
        unset($_SESSION['shopping_cart']['count_money']);
        foreach($_SESSION['shopping_cart'] as $array) {
            $sql .= " WHEN {$array['id']} THEN (products.amount - {$array['quantity']} ) ";
        }
            
        $sql .= " ELSE products.amount
                END ";
        $result = mysqli_query($conn, $sql);

        $_SESSION['shopping_cart'] = [];
        header("location: $url?message=ההזמנה נשלחה בהצלחה");
    }else {
        header("location: $url?errorMessage=קיימת בעיה בהזמנה אנא נסה שוב מאוחר יותר");
    }
    exit;

}

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>

<!DOCTYPE html>
<html>

<head>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	

	<title>שיפודי התקווה חולון</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="stylesheet" href="deliveries.css" />
	<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">


</head>


<body>


<?php displayMessage(); ?>

		<div class="container">
<div id="title"><h1>תפריט משלוחים</h1></div>

			<?php
	$query = 'SELECT * FROM `products` ORDER BY product_id ASC';
	$result = mysqli_query($connect, $query);
	if($result):
		if(mysqli_num_rows($result)>0):
			while($product = mysqli_fetch_assoc($result)):
			
			?>



				<div class="col-sm-4 col-md-3">



					<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>?action=add&id=<?php echo $product['product_id']; ?>">
						<div class="products">
							<?php if( !empty($product['image']) && file_exists($product['image']) ): ?>
                                <img src="<?php echo $product['image']; ?>" class="img-responsive product-image" />
                            <?php else: ?>
                                <img src="images/5ccea94c209f70.15473612.jpg" class="img-responsive product-image" />
                            <?php endif; ?>

							<h4 class="text-primary product-title">
								<?php echo $product['name']?>
							</h4>
							<div> <!-- available in stock? -->
                                <?php 
                                    if ($product['amount'] > $product['min_amount']){
                                        $productInStock = true;
                                       
                                    } else{
                                        $productInStock = false;
                                        echo '<h6 class="error-in-stock">לא זמין במלאי</h6>';
                                    }
								?>
                            </div>
                            <br>

                            <?php if(!empty($pitas)):
                                    $count_pitas = count($pitas);
                                ?>
                            <br>
                            <h5 class="text-primary order-title"> ארוחה:</h5>
                            <div class="inputs"> 
                                <?php $i = 0; ?>
                                <?php foreach($pitas as $pita): ?>
                                    <?php if($pita['min_amount'] > $pita['amount']){
                                        $inStock = false;
                                    } else {
                                        $inStock = true;
                                    }
                                    if($i == 0) {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }
                                    ?>
                                    <input class="order-text-deliveries pita-product" <?php echo $inStock ? '' : 'disabled' ?> <?php echo $checked ?> type="radio" name="pita" value="<?php echo $pita['name'] ?>"> <span class="order-text-deliveries text-info"><?php echo $pita['name'] ?></span>
                                    <input class="pita-price" type="hidden" name="pita_price" value="<?php echo $pita['price'] ?>">
                                    <?php if(!$inStock): ?>
                                        <h6 style="color:red; padding:2px;text-align:left; display: inline; font-weight:bold;">לא זמין במלאי</h6>
                                    <?php endif; ?>
                                    <br>  
                                <?php $i++; ?>
                                <?php endforeach; ?>
                                <input class="pita-selected-price" type="hidden" name="pita_selected_price" value="<?php echo $pitas[0]['price'] ?>">
                                <input type="hidden" name="pita_count" value="<?php echo $count_pitas ?>">
                            </div>
                            <?php endif; ?>    

                            <?php if(!empty($sauces)): ?>
                            <br>
                            <h5 class="text-primary order-title">רטבים:</h5>
                            <div class="inputs">
                                <?php $i = 0; ?>
                                <?php foreach($sauces as $sauce): ?>
                                <?php if($sauce['min_amount'] > $sauce['amount']){
                                        $inStock = false;
                                    } else {
                                        $inStock = true;
                                    } ?>
                                <input class="order-text-deliveries" <?php echo $inStock ? '' : 'disabled' ?> type="checkbox" name="sauce_<?php echo $i ?>" value="<?php echo $sauce['name'] ?>"> <span class="order-text-deliveries text-info"><?php echo $sauce['name'] ?> </span>
                                <input type="hidden" name="sauce_<?php echo $i ?>_id" value="<?php echo $sauce['id'] ?>">
                                <?php if(!$inStock): ?>
                                    <h6 style="color:red; padding:2px;text-align:left; display: inline; font-weight:bold;">לא זמין במלאי</h6>
                                <?php endif; ?>
                                <br>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                                <input type="hidden" name="sauce_count" value="<?php echo count($sauces) ?>">
                            </div>
                            <?php endif; ?>    

                            <?php if(!empty($vegetables)): ?>
                            <br>
                            <h5 class="text-primary order-title">תוספות:</h5>
                            <div class="inputs">
                                <?php $i = 0; ?>
                                <?php foreach($vegetables as $vegetable): ?>
                                <?php if($vegetable['min_amount'] > $vegetable['amount']){
                                        $inStock = false;
                                    } else {
                                        $inStock = true;
                                    } ?>
                                <input class="order-text-deliveries" <?php echo $inStock ? '' : 'disabled' ?> type="checkbox" name="vegetable_<?php echo $i ?>" value="<?php echo $vegetable['name'] ?>"> <span class="order-text-deliveries text-info"><?php echo $vegetable['name'] ?> </span>
                                <input type="hidden" name="vegetable_<?php echo $i ?>_id" value="<?php echo $vegetable['id'] ?>">
                                <?php if(!$inStock): ?>
                                    <h6 style="color:red; padding:2px;text-align:left; display: inline; font-weight:bold;">לא זמין במלאי</h6>
                                <?php endif; ?>
                                <br>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                                <input type="hidden" name="vegetable_count" value="<?php echo count($vegetables) ?>">
                            </div>
                            <?php endif; ?>    

                            <br>
							<h5 class="text-info container-price" style="color:black; font-weight:bold; overflow:hidden;">
                                <span class="price"><?php echo $product['price'] + $pitas[0]['price']?></span> &#8362;</h5>
                            <br>
							<div class="inputs">
                                <h5 class="text-primary order-title">כמות:</h5>
                                <input type="text" class="form-control" name="quantity" value="1" />
                                <br>
                                <h5 class="text-primary order-title">הערות:</h5>
								<textarea class="form-control" name="notes" placeholder="הערות" ></textarea>
								<input type="hidden" name="name" value="<?php echo $product['name'] ?>" />
								<input class="product-price" type="hidden" name="price" value="<?php echo $product['price'] ?> " />
								<input type="submit" <?php echo $productInStock ? '' : 'disabled title="מוצר זה לא זמין במלאי"'; ?> name="add_to_cart" style="margin-top:5px; background-color: orange;" class="btn"
                                   value="הוסף לסל" />
                            </div>
                            
						</div>


					</form>
				</div>

				<?php
					endwhile;
				endif;
			endif;
					?>
					<div style="clear:both"></div>  
       
        <br>  
        
        <hr>  
        
        <?php
        if(!empty( $_SESSION['shopping_cart'])):  
            
             $total = 0;  
        
             
        ?>  
        <div class="table-responsive">  
        <table class="table" style="direction:rtl;">  
            <tr><th colspan="5"><h3 style="text-align:right;">פרטי הזמנה</h3></th></tr>   
            
        <tr>  
             <th >שם המוצר</th>
             <th >כמות</th> 
             <th >מחיר</th>
             <th >רטבים</th> 
             <th >ירקות</th>
             <th >סוג ארוחה</th>  
             <th >סך הכל</th> 
             <th width="20px" >הסרת פריט</th> 
        </tr>
        <?php foreach($_SESSION['shopping_cart'] as $key => $product):  ?>
        <tr>  
           <td><?php echo $product['name']; ?></td>  
           <td><?php echo $product['quantity']; ?></td>  
           <td><?php echo (float) $product['price'] + (float) $product['pita_price'] ?> &#8362;</td>  
           <td>
                <?php 
                    if( !empty($product['sauces']) ){
                        for($i = 0; $i < count($product['sauces']); $i++) {
                            if(!empty($product['sauces'][$i]['sauce_'.$i])) {
                                echo $product['sauces'][$i]['sauce_'.$i]['name'] .' <br>'; 
                            }
                        }
                    } else{
                        echo 'ללא רטבים';
                    }
                ?>
           </td>

           <td>
           <?php 
                if( !empty($product['vegetables']) ){
                    for($i = 0; $i < count($product['vegetables']); $i++) {
                        if(!empty($product['vegetables'][$i]['vegetable_'.$i])) {
                            echo $product['vegetables'][$i]['vegetable_'.$i]['name'] .' <br>'; 
                        }
                    }
                } else{
                    echo 'ללא ירקות';
                }
                    
                 ?>
           </td>

           <td>
                <?php echo $product['pita']; ?>
           </td>

           <td><?php echo number_format( ((float)$product['quantity'] * (float)$product['price']) + ((float)$product['quantity'] * (float)$product['pita_price']) , 2); ?>&#8362;</td>  
           <td>
               <a href="deliveries.php?action=delete&id=<?php echo $key ?>">
                    <div class="btn-danger" id="removeItem">הסר</div>
               </a>
           </td>  
        </tr>  
        <?php  
                  $total = $total + ((int)$product['quantity'] * (float)$product['price']) + ((int)$product['quantity'] * (float)$product['pita_price']);  
             endforeach;  
        ?>  
        <tr>  
             <td colspan="6" align="right">Total : </td>  
             <td align="right"><?php echo number_format($total, 2); ?>&#8362;</td>  
             <td>&nbsp;</td>  
        </tr>  
        <tr>
            <!-- Show checkout button only if the shopping cart is not empty -->
            <td colspan="8">
             <?php 
                if (isset($_SESSION['shopping_cart'])):
                if (count($_SESSION['shopping_cart']) > 0):
             ?> 
-->

                <?php include_once 'templates/deliversAddressForm.php'; ?>

                <a href="deliveries.php?action=saveorder" class="button" id="successShopping" onclick="return false">סיימתי!</a>
             <?php endif; endif; ?>
            </td>
        </tr>
        <?php  
        endif;
        ?>  
        </table>  
         </div>
        
		</div>

        <footer><?php include 'footer.php'; ?></footer>

        <script>
            $('.pita-product').on('change', function() {
                
                // get the input that contains the price of the dinner
                var dinnerPriceEl = this;
                while(dinnerPriceEl.nextSibling) {
                    var valid = true;

                    if(typeof dinnerPriceEl.classList == 'null' || typeof dinnerPriceEl.classList == 'undefined')
                        valid = false;

                    if( valid && dinnerPriceEl.classList.contains('pita-price') ) break;
                    else dinnerPriceEl = dinnerPriceEl.nextSibling;
                }

                var parent = this.parentElement;
                var priceEl = $(parent.parentElement).find('.price');
                var priceProduct = parseFloat( $(parent.parentElement).find('.inputs .product-price').val() );
                var addToPrice = parseFloat(dinnerPriceEl.value);

                priceProduct += addToPrice;

                priceEl.text( priceProduct );
                $(parent.parentElement).find('.inputs .pita-selected-price').val(addToPrice);
            })

        </script>

        
        <script type="text/javascript">
        $('#successShopping').on('click', function(e) {
            var address = $('#address').val();
            var contactName = $('#contactName').val();
            var city = $('#city').val();
            var floor = $('#floor').val();
            var apartment = $('#apartment').val();
            var entry = $('#entry').val();
            var phone = $('#phone').val();
            var deliverNote = $('#deliverNote').val();

            if(!address.length) {
                $('#addressError').show();
                return;
            }

            var params = '?action=saveorder';
            params += '&address=' + address;
            params += '&contactName=' + contactName;
            params += '&city=' + city;
            params += '&floor=' + floor;
            params += '&apartment=' + apartment;
            params += '&entry=' + entry;
            params += '&phone=' + phone;
            params += '&deliverNote=' + deliverNote;

            window.location.href = window.location.pathname + params ;
        });

    </script>

</body>

</html>
