<?php
session_start();
if($_SESSION['user']){
unset($_SESSION['user']);
}
if($_SESSION['admin'])
{
unset($_SESSION['admin']);
}

session_destroy();
include_once 'header.php';

header('refresh:2; url=index.php');

?>


<html>
	

	<body>
			<div class="container">
		<div class="row">
		
				<div class="col-lg-3"></div>

				<div class="col-lg-6" id="formContainer">
		<center style='padding:20px;'>
		<h3 style="padding:5px;">הנך מועבר לדף הבית</h3>
		</center>
				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>
		<?php include('footer.php') ?>
	</body>
</html>
