

<!DOCTYPE html>

<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'header.php';

?>
	<html lang="">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>
			<div class="container">
		<div class="row">
		
				<div class="col-lg-3"></div>

				<div class="col-lg-6" id="formContainer">
					<form method="post" action="#">
					<h2 style="color:#41414E;margin-bottom:2%;">צור קשר</h2>
						<small>אנא שלח את הודעתך ותזכה למענה ב24 השעות הקרובות.</small>
						<p>נושא : <input type="text" name="subject"></p>
						<p>כתובת מייל : <input type="email" name="email"></p>
						<p>הודעה:</p>
						<p><textarea cols="40" rows="5" name="message"></textarea></p>
						<div class="input-group">
							<button type="submit" name="send" class="btn">שלח</button>
						</div>

					</form>

				</div>
				<div class="col-lg-3"></div>


			</div>
		</div>
	</body>
    <?php include('footer.php') ?>
	</html>
	