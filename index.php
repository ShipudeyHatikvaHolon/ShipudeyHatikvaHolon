<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="UTF-8">
	<meta name="google-site-verification" content="OYNQ7cDcgb6NU6hyGo5h_IgstcLFQdTh59m5j4sVFio" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300 | Arimo" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bellefair" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo" rel="stylesheet">


	<title>שיפודי התקווה חולון</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>

<body>

	<div class="img-responsive" id="mainImage">
		<div class="container-fiuld">


			<div class="row">
			
				<div class="col-12">
					<nav>
						<div class="col-12">
							<div id="topnav">
								<ul>
								<?php if(empty($_SESSION['user_name'])): ?>
									<a href="register.php">
										<li>הרשמה</li>
									</a>

									<li id="logBtn" data-toggle="modal" data-target="#myModal">התחברות</li>
									<?php else: ?>

<?php echo '<li><span class="right" style="color:#fff;">שלום, <span id="name" style="color:white;">' . $_SESSION['user_name'] . '</span> <br> <a href="logout.php "style="color:red;">התנתק</a> </span></li>'; ?>

<?php endif; ?>
								</ul>

							</div>

						</div>




					</nav>
				</div>
			</div>
			<header>
				<div class="row">


					<div class="col-xs-2 col-md-3">
					
						<div class="modal fade" id="myModal" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<p>התחבר למערכת</p>
									</div>
									<div id="logInBox">
										<form id="logIn" method="post" action="process.php">

			<p><input type="email" autofocus name="email" required placeholder="כתובת מייל"></p>
			
			<p><input type="password" name="password" required placeholder="סיסמא"> </p>


											<input type="submit" value="התחבר">
										</form>
									</div>
								</div>

							</div>
						</div>


					</div>
					<div class="col-xs-10 col-md-6">



						<div id="nav">
							<ul>
								<a href="calendarTest4.php">
									<li>הזמנת שולחן במסעדה</li>
								</a>
								<a href="deliveries.php">
									<li>משלוחים</li>
								</a>
								<a href="vouchers.php">
									<li>רכישת שוברים</li>
								</a>
							</ul>
						</div>
					</div>
					<div class="col-md-3">

						<div id="logo">
							<a href="index.php"><img src="images/logo.png" alt="logo" /></a>
						</div>
					</div>


				</div>
			</header>


			<div class="row">
				<div class="col-12">
					<div id="bigPhoto">
						<h1 style="color:orange">שיפודי התקווה חולון</h1>
						<h2></h2>
						<input type="button" style="color:orange" onclick="location.href='#';" value="!הזמן משלוח עכשיו" id="centerBtn">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-sm-4 slideanim">
			<div class="offer">

				<h2>שוברים</h2>
				<div class="offerimg"><img src="images/vouchers.jpeg" alt="member" /></div>

			</div>
			<div class="offerText">

				<p>מבצעים מיוחדים ברכישת שוברים רק אצלנו בשיפודי התקווה חולון</p>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="offer">
				<h2>משלוחים עד הבית</h2>
				<div class="offerimg"><img src="images/FoodDelivery.png" alt="FoodDelivery" /></div>

			</div>
			<div class="offerText">
				<p>משלוחים חינם לחולון ואזור למזמינים מעל 50 ש"ח באתר </p>
			</div>
		</div>

	

		<div class="col-sm-4">
			<div class="offer">
				<h2>הטבות ומבצעים</h2>
				<div class="offerimg"><img src="images/FoodCoupons.png" alt="sales" /></div>

			</div>
			<div class="offerText">

				<p>הרשמו לאתר ולא תפספסו את הקופונים השווים שלנו </p>
			</div>

		</div>


	</div>


			<footer>
			<div class="row">



				<div class="col-12">
					<div id="footerLinks">
						<ul>
							<a href="map.html">
								<li>מיקום </li>
							</a>
							<a href="contact.php">
								<li>צור קשר</li>
							</a>


						</ul>
						<p>מסעדת שיפודי התקווה, הפלד 7 חולון - 03-9453366
						<p style="font-size: 12px;">&copy כל הזכויות שמורות לעמית בנדט, רובי סומך ועידן זולברג</p>
					</div>
					<a href="https://www.facebook.com/%D7%A9%D7%99%D7%A4%D7%95%D7%93%D7%99-%D7%94%D7%AA%D7%A7%D7%95%D7%95%D7%94-%D7%97%D7%95%D7%9C%D7%95%D7%9F-458821907872310/"><img id="facebookImg" src="images/facebook.jpg" width=100px/>
</a>
				</div>




			</div>

		</footer>
	</div>

		<!-- Optional JavaScript -->
		<!-- jQuery fir,st, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


		<script>
			$(document).ready(function() {
				var imageDiv = $("#mainImage");
				var backgrounds = new Array(
					'url("images/ST1.jpg")', 'url("images/ST2.jpg")',
					'url("images/ST3.jpg")'
				);

				var current = 0;

				function nextBackground() {
					current++;
					current = current % backgrounds.length;
					imageDiv.css('background-image', backgrounds[current]);
					imageDiv.css('transition', '1s ease-out');
				}
				setInterval(nextBackground, 3000);

				imageDiv.css('background-image', backgrounds[0]);
			});

			$('#centerBtn').on('click', function() {
				window.location.href = 'deliveries.php';
			});

		</script>

</body>
</html>
