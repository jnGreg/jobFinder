<?php
include "includes/config.inc.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Language"
	content="język" />
	<meta http-equiv="Content-Type"
	content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name = "author" content = "Jan Gregor" />
	<title>Sign Up</title>
	<link rel="Stylesheet" type= "text/css" href = "css/bootstrap.min.css" />
	<link rel="Stylesheet" type= "text/css" href = "css/style.css?version=1" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
	<header>
		<?php
		require_once "includes/header.inc.php";?>
	</header>

	<main><center> 
		<div id = "container" class="container-fluid" style="background-color: #E4FAFF; border-radius: 25px;">
			<form method="POST" action="includes/register.inc.php"> <br><h4> Sign Up to jobFinder </h4><br>
				<?php   
				if(isset($_GET["error"])){ 
					if ($_GET["error"] == "emptyinput"){
						echo "<h2 style='color:red;'>Fill in all fields.</h2>";
					}}?>
				<div id="register_div" class="col-4 col-sm-5 col-md-6 col-lg-7 col-xl-8" >
					
					<!--- part 3 z ponizszymi ---><br><br>
					<div class="form-group">
					<input class="form-control" type="text" placeholder="username..." name = "f_username" size="42"> </div>
					<?php   
					if(isset($_GET["error"])){ 
					if ($_GET["error"] == "invalidusername"){
						echo "<h2 style='color:red;'>Username must be between 5 and 20 characters and contain only letters and numbers.</h2>";
					} 
					else if ($_GET["error"] == "usernametaken"){
						echo "<h2 style='color:red;'>Username taken.</h2>";
					}}?>
					<div class="form-group">
					<input class="form-control" type="email" placeholder="Adres email..." name = "f_email" size="42"> </div>
					<?php   
					if(isset($_GET["error"])){ 
					if ($_GET["error"] == "invalidemail"){
						echo "<h2 style='color:red;'>Incorrect email address.</h2>";
					} 
					else if ($_GET["error"] == "emailtaken"){
						echo "<h2 style='color:red;'>A user with this email address already exists.</h2>";
					}}?>
					<div class="form-group"><br>
					<input class="form-control" type="password" placeholder="password..." name = "f_password" size="42"> </div>
					<div class="form-group">
					<input class="form-control" type="password" placeholder="repeat password..." name = "f_password_repeat" size="42"> </div>
					<?php   
					if(isset($_GET["error"])){ 
					if ($_GET["error"] == "invalidpassword"){
						echo "<h2 style='color:red;'>Password must be at least 8 characters long.</h2>";
					} 
					else if ($_GET["error"] == "passwordsdontmatch"){
						echo "<h2 style='color:red;'>Passwords don't match.</h2>";
					}}?>
					<input class="form-control" type="date" name = "f_register_date" size="42" hidden> 
					<label><br>
      				<input type="checkbox" name="f_accept_rules"> I have read and accept <a href = "terms.php"> Terms of Service <br>
      					<br></a><?php   
					if(isset($_GET["error"])){ 
					if ($_GET["error"] == "rulesnotaccepted"){
						echo "<h2 style='color:red;'>Accept Terms of Service.</h2>";
					} }?>
    				</label>
					<br> <br>
					<button class="btn btn-success" style="width: 50%;" type="submit" name="f_submit">Sign Up!</button>
				</form> <br><br><br> 
				<?php 
					if(isset($_GET["error"])){ 
					if ($_GET["error"] == "stmtfailed"){
						echo "<script>alert('Something has gone wrong. Try again.')</script>";
					} 
				}?>
				<p> <br><br><br> Back to the login page? <a href="login.php">Sign In</a></p>
		</div></center>
		
	</main>
	<footer>
		<?php
						require_once "includes/footer.inc.php"; ?>
	</footer>
</div> </div>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.js">  </script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>