<?php
	session_start();

   // Check if the user is already logged in, if yes then redirect him to welcome page
   if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      if(strcmp($_SESSION["user"], "user") == 0)  
         header("location: myMovies/myMovies.php");
      else if(strcmp($_SESSION["user"], "dev") == 0 || strcmp($_SESSION["user"], "admin") == 0)  
         header("location: admin_account/myMovies.php"); 
       exit;
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V6</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form validate-form" action="user_login.php" method="post">
					<span class="login100-form-title p-b-70">
						Welcome
					</span>
						<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Enter username">
							<input class="input100" type="text" name="username">
							<span class="focus-input100" data-placeholder="Username"></span>
						</div>

						<div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
							<input class="input100" type="password" name="password">
							<span class="focus-input100" data-placeholder="Password"></span>
						</div>

						<div class="container-login100-form-btn">
							<input type="submit" value="Login" class="login100-form-btn">
								
							
						</div>
					<ul class="login-more p-t-190">

						<li>
							<span class="txt1">
								Don’t have an account?
							</span>

							<a href="signup.html" class="txt2">
								Sign up
							</a>
						</li>
						<li>
							<span class="txt1">
								Want to have a short tour?
							</span>

							<a href="guest/guest.php" class="txt2">
								Login as Guest
							</a>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>