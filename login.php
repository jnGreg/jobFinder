
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Language"
	content="język" />
	<meta http-equiv="Content-Type"
	content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name = "author" content = "Jan Gregor" />
	<title>Sign In</title>
	<link rel="Stylesheet" type= "text/css" href = "css/bootstrap.min.css" />
	<link rel="Stylesheet" type= "text/css" href = "css/style.css?version=1" />

</head>
<body>
	<header>
		<?php
		require_once "includes/header.inc.php"; ?>
	</header>

	<main>
		<center>
		<div id = "container" class="container-fluid" style="background-color: #E4FAFF; border-radius: 25px; min-height: 613px;">
				<div id="login_div" class="col-3 col-sm-4 col-md-5 col-lg-6 col-xl-7">
					<div class="form-group">
					<form method="POST" action="includes/login.inc.php"><br><br> <br><h4> Log In To Your Account</h4><br><br><br>
						<input class="form-control" type="text" placeholder="username or email address..." name = "f_username" size="42"> <br><br>
						<input class="form-control" type="password" placeholder="password..." name = "f_password" size="42"> 
						<br><br> <br>
						<button class="btn btn-success" style="width: 50%;" type="submit" name="f_submit">Sign In </button>
					</form> <br><br>
					<?php   
				if(isset($_GET["error"])){
					if ($_GET["error"] == "emptyinput"){
						echo "<h2 style='color:red;'>Fill in all fields.</h2><br>";
					}
					else if ($_GET["error"] == "wronglogin"){
						echo "<h2 style='color:red;'>Incorrect login details.</h2><br>";
					}
					else if ($_GET["error"] == "stmtfailed"){
						echo "<h2 style='color:red;'>Something has gone wrong. Try again.</h2><br>";
					} 
				}?>
					<p>Don't have an account yet? <a href="register.php">Sign Up</a></p>
				</div></div>
				</center>
			</main>
			<footer>
			<?php
						require_once "includes/footer.inc.php"; ?>
			</footer>
		</div> </div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>

	</html>


