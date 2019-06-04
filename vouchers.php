<?php  include_once 'header.php'; ?>


<?php 

if(!empty($_SESSION['id'])) {
	$user = $_SESSION['id'];
}
?>


<html>

<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="vouchers.css" />
	
	<script src="vouchers.js"></script>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
</head>


<body>
	<?php displayMessage(); ?>
	<div class="row">
		<div class="col-md-6" id="manooy">
<h2> רכישת שוברים</h2>
		<p>	לפניכם תפריט השוברים במסעדה, אנא בחרו את סוג השובר המבוקש.
			<br>
על כל שובר ניתן לראות את פרטי השובר באמצעות לחיצה על כפתור "הצג פרטי שובר".
	</br>
	<br>
לתשומת לבכם , תשלום על השובר המוזמן תתבצע בעת הביקור הראשון במסעדה , במזומן או בכרטיס אשראי בלבד. 
	</br>
</p>
			<form  action="vouchersConf.php"method="post">

				<label>בחר סוג שובר : </label>
				<select id="treatmentSelect" name="treatment">
				<option value="">בחר שובר</option>
  <option value="1" >שיפודים בחמגשית</option>
  <option value="2" >שיפודים בפיתה</option>
  <option value="3" >שיפודים בלאפה</option>
  <option value="4" >פלאפל בפיתה</option>
  
</select>
		<div id="target"></div>
		
			<button type="submit" class="action-button shadow animate blue" onclick="">בצע הזמנה</button>
			</form>
		<button class="action-button shadow animate blue" id="showInfo" onclick="getInfo()">הצג פרטי שובר</button>	
	
		
			
		</div>
	</div>
	

<footer>
<?php require 'footer.php'?>
</footer>	
</body>

</html>
