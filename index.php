<?php
session_start(); 
include ('includes/config.inc.php');
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
	<title>jobFinder - job offers from jjit</title>
	<link rel="Stylesheet" type= "text/css" href = "css/bootstrap.min.css" />
	<link rel="Stylesheet" type= "text/css" href = "css/style.css?version=1" />
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
	<header>
		<?php
		require_once "includes/header.inc.php"; ?>
	</header>

	<main>
		<center>
			<div id = "container">
				<center> <h1>Quick search </h1><br>
					<?php 
					require_once "includes/search.inc.php";?>

						<br><br><br><br>
						<h1>By Category</h1>
						<section class="kategorie">
							<div class="row justify-content-center">

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">
									<figure> 
										<a href="search.php?view=list&ctgr=1"><img src="img/ctgrs/admin.JPG" alt="admin" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=1">Admin</a></h5></figcaption>
										</figure> 
								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure >
										<a href="search.php?view=list&ctgr=2"><img src="img/ctgrs/analytics.JPG" alt="analytics" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=2">Analytics</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=3"><img src="img/ctgrs/architecture.JPG" alt="architecture" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=3">Architecture</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=4"><img src="img/ctgrs/data.JPG" alt="data" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=4">Data</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=5"><img src="img/ctgrs/devops.JPG" alt="devops" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=5">DevOps</a></h5></figcaption>
									</figure>
										
								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=6"><img src="img/ctgrs/ux.JPG" alt="ux" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=6">UX/UI</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=7"><img src="img/ctgrs/game.JPG" alt="game" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=7">Game</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=8"><img src="img/ctgrs/pm.JPG" alt="pm" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=8">PM</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=9"><img src="img/ctgrs/security.JPG" alt="security" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=9">Security</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=10"><img src="img/ctgrs/support.JPG" alt="support" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=10">Support</a></h5></figcaption>
									</figure>

								</div>					

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=11"><img src="img/ctgrs/testing.JPG" alt="testing" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=11">Testing</a></h5></figcaption>
									</figure>
										
								</div>						

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=12"><img src="img/ctgrs/other.JPG" alt="other" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=12">Other</a></h5></figcaption>
									</figure>

								</div>	

							<br><br><br><br><br><br><br>
						<br><br><br><br><br>
						<h1>By Technology</h1>
						<br><br>
						<section class="kategorie">
							<div class="row justify-content-center">

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">
									<figure> 
										<a href="search.php?view=list&ctgr=13"><img src="img/ctgrs/c.JPG" alt="c" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=13">C</a></h5></figcaption>
										</figure> 
								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=14"><img src="img/ctgrs/go.JPG" alt="go" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=14">Go</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=15"><img src="img/ctgrs/html.JPG" alt="html" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=15">HTML</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=16"><img src="img/ctgrs/java.JPG" alt="java" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=16">Java</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure >
										<a href="search.php?view=list&ctgr=17"><img src="img/ctgrs/js.JPG" alt="js" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=17">JS</a></h5></figcaption>
									</figure>
									
								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=18"><img src="img/ctgrs/mobile.JPG" alt="mobile" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=18">Mobile</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=19"><img src="img/ctgrs/.net.JPG" alt=".net" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=19">.Net</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=20"><img src="img/ctgrs/php.JPG" alt="php" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=20">PHP</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=21"><img src="img/ctgrs/ruby.JPG" alt="ruby" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=21">Ruby</a></h5></figcaption>
									</figure>

								</div>

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=22"><img src="img/ctgrs/python.JPG" alt="python" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=22">Python</a></h5></figcaption>
									</figure>

								</div>					

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=23"><img src="img/ctgrs/scala.JPG" alt="scala" class="img-fluid"></a>

									<figcaption>
											<h5><a href="search.php?view=list&ctgr=23">Scala</a></h5></figcaption>
								</div>						
									</figure>
									

								<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">

									<figure>
										<a href="search.php?view=list&ctgr=24"><img src="img/ctgrs/erp.JPG" alt="erp" class="img-fluid"></a>
										<figcaption>
											<h5><a href="search.php?view=list&ctgr=24">ERP</a></h5></figcaption>
									</figure>

								</div>	
								<center>
								</div>
							</section>
							<br><br><br>

						</center><br><br>
						
					</main>
					<footer>
						<?php
						require_once "includes/footer.inc.php"; ?>
					</footer>

					<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
					<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
					<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
					<script type="text/javascript" src="js/jquery.js">  </script>
					<script src="js/bootstrap.min.js"></script>
				</body>

				</html>


