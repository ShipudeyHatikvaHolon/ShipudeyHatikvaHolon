<?php
require_once 'configur.php';
session_start();


?>




<!DOCTYPE html>



<html>
<head>
		<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300 | Arimo" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bellefair" rel="stylesheet">


	<title> שיפודי התקווה </title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<style>
	body {
  font: normal 100%/1.5 Verdana, sans-serif;
  color: #FAFAFA; 
  background:#FAFAFA; 
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  font-smoothing: antialiased;
}

a {
  color:Orange;
  text-decoration: none;
}

.button {
  display: inline-block;
  line-height: 3em;
  padding: 0 1em;
  background: #3B3B47;
  border-radius: 0.125em;
  background-clip: padding-box;

  margin-right: 1em
}

.button:before {
    content: "\2190";
}

.button--plain {
	background: #41414E;
		
}

		.button--plain:hover{
			color:white;
			border:0.3px solid 	aqua;
		}
		div#buttons {
			margin:0 auto;
			margin-top: 4%;
			position:relative;
			
			
		}
		
		#mainHeader{
			margin-top:5%;
			text-align: center;
			color: Orange;
			padding: 2px;
			font-weight: 600;
			font-family: calibri;
		}
		
		footer{
			margin-top: 5%;
			background: none;
			color:#7CBDBA;
			
		}
		@media (max-width:576px){
		 #mainHeader{
		     margin-bottom:30px;
		 }   
		}
	</style>
</head>
		
	<body>
<h1 id="mainHeader">  מערכת לניהול מסעדת שיפודי התקווה - חולון</h1>
	<div class="row">
		<div class="container">
			
						<div class="col-lg-12" id="buttons">
						    <center>
						        				<a class="button button--plain" href="#">יומן המסעדה</a>			
						<a class="button button--plain" href="#">עמוד דוחות</a>	
												<a class="button button--plain" href="#">ניהול שולחנות</a>

						
			</center>
		</div>
		</div>
	</div>
	
	<div class="row">
		<div class="container">
			<center>
						<div class="col-lg-12" id="buttons">
						<a class="button button--plain" href="#">ניהול שוברים</a>			
						<a class="button button--plain" href="#">ניהול חנות</a>					
						<a class="button button--plain" href="#">הוספת מוצר</a>			
						</center>
		</div>
		</div>
		
			<div class="row">
		<div class="container">
			<center>
						<div class="col-lg-12" id="buttons">
						<a class="button button--plain" href="index.php" style="color:red;">התנתקות</a>	
						</center>
		</div>
		</div>
		
		
	</div>
	
	<?php
		include_once 'footer.php';	
		
		?>
	</body>
	
</html>
