
<?php 


$user = $_SESSION['user_id'][$id];
?>


<html>

<head>

	<link rel="stylesheet" href="vouchers.css" />
	
	<script src="vouchers.js"></script>

</head>


<body>
	<div class="row">
		<div class="col-md-6" id="manooy">
<h2> רכישת שוברים</h2>
		<p>	לפניכם תפריט השוברים במסעדה, אנא בחרו את סוג השובר המבוקש.
			<br>
	לאחר בחירת השובר, הוסיפו את פרטיכם האישים וההזמנה תשלח לאישור.
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
		
			<button type-"submit" class="action-button shadow animate blue" onclick="">בצע הזמנה</button>
			</form>
		<button class="action-button shadow animate blue" id="showInfo" onclick="getInfo()">הצג פרטי שובר</button>	
	
		
			
		</div>
	</div>
	


</body>

</html>
