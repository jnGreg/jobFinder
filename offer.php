<?php
require ('includes/config.inc.php');
session_start(); 

$sql = "SELECT * FROM offers WHERE offer_id = '".$_GET['offer_id']."'"; 
$results = mysqli_query($conn, $sql); 
if(mysqli_num_rows($results)>0){
while($row = mysqli_fetch_array($results)) {
	$offer_id = $row['offer_id'];
	$jj_id = $row['jj_id'];
	$company_name = $row['company_name'];
	$title = $row['title'];
	$workplace_type = $row['workplace_type'];
	$experience_level = $row['experience_level'];
	$ctgr_id = $row['ctgr_id'];
	$add_date = $row['published_at'];
	$photo = $row['company_logo_url'];
	$company_url = $row['company_url'];

	$city = $row['city'];
	$friendly = $row['open_to_hire_ukrainians'];
	$full_address = $row['address_text'];
	$company_size = $row['company_size'];
	$ctgr_id = $row['ctgr_id'];
}
}
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
	<title>Offer <?php echo $offer_id; ?></title>
	<link rel="Stylesheet" type= "text/css" href = "css/bootstrap.min.css" />
	<link rel="Stylesheet" type= "text/css" href = "css/style.css?version=1" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
	<header>
		<?php
		require_once "includes/header.inc.php"; ?>
	</header>

	<main>
		<center>
			<div id = "container" style="width:1000px; margin-top: 120px; margin-bottom: 120px;">
				<h2>Look for another offer</h2><br>
			<?php 
			require_once "includes/search.inc.php";?>
			<br>
				<p style="align:left;"><a href="index.php">Main Page</a>&nbsp>>>&nbsp<?php $query = "SELECT * FROM ctgrs WHERE ctgr_id = '$ctgr_id';";
				$results = mysqli_query($conn, $query); 
				while($row = mysqli_fetch_array($results)) {
					?>
					<a href="search.php?view=list&ctgr=<?php echo $row['ctgr_id'];?>"><?php echo $row['category']; } ?> </a></p>
							<?php 
							$results = mysqli_query($conn, $sql); ?>

							<h5>Title: </h5><h4><?php echo $title; ?></h4> <br><br>	
							<h5>Image: </h5>
									<img id="image" style = "width:100px; height:100px; margin-left:20px; border-radius:50%;" src="<?php echo $photo; ?>"> 

					
										<br><br><br>
										<div id="map-container-google-9" class="z-depth-1-half map-container-5" style="height: 300px">
											<h5>Location: </h5> <h4><?php echo $full_address; ?></h4> <br><br>	
										<iframe src="https://maps.google.com/maps?q=<?php echo $full_address; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
										style="border:0" allowfullscreen></iframe>
										</div><br>
										<h5>Offer address: </h5> <a href="<?php $link_address = 'https://justjoin.it/offers/' . $jj_id;
										echo $link_address; ?>"><?php echo $link_address; ?></a> <br><br>

										<h5>Company name & address: </h5> <a href="<?php
										echo $company_url; ?>"><?php echo $company_name . ', ' . $company_url; ?></a> <br><br>

										<h5>Skillset: </h5>
										<?php 
										$query_skills = "SELECT * FROM skills WHERE jj_id = '$jj_id';";
														$results_skills = mysqli_query($conn, $query_skills); 
														while($row = mysqli_fetch_array($results_skills)) {
														$skill_name = $row['name'];
														$skill_level = $row['level'];
														?><h4><?php
														echo $skill_name . ': ' . $skill_level . '/5 '; ?></h4><?php }?>
										   <br><br>	

										 <h5>Employment: </h5>
										<?php 
										$query_empl = "SELECT * FROM employment WHERE jj_id = '$jj_id';";
														$results_empl = mysqli_query($conn, $query_empl); 
														while($row = mysqli_fetch_array($results_empl)) {
														$empl_type = $row['type'];
														$min = $row['from'];
														$max = $row['to'];
														$currency = $row['currency'];
														?><h4><?php
														echo $empl_type . ': ' . $min . ' - '. $max  . ' ' . $currency; ?></h4><?php }?>
										   <br><br>	

												<?php if (isset($_SESSION['userid'])) { ?>
												<p><form method = "post" action = "includes/observe.inc.php">

													<input type="number" name="f_offer_id" value="<?php echo $offer_id; ?>" hidden>
													<button type="submit" name="f_submit" class="btn-warning round">Observe</button></form></p> <?php 

													if(isset($_GET["error"])){ 
														if ($_GET["error"] == "stmtfailed"){
															echo "<h2 style='color:red;'>Something went wrong. try again!</h2>";
														} 
														else if ($_GET["error"] == "alreadywatched"){
															echo "<h2 style='color:red;'>You are already watching this offer!</h2>";
														} 
														else {
															echo "<h2 style='color:blue;'>Added to watchlist!</h2>";
														}
													}
												} ?>
											</div>

										</main>
											<footer>
												<?php 
												require_once "includes/footer.inc.php"; ?>
											</footer>

											<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
											<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
											<script src="js/bootstrap.min.js"></script>
											<script src="js/toggleDarkLight.js"></script>
											<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
											<script type="text/javascript" src="js/jquery.js">  </script>
										</body>

										</html>


										<?php $conn->close(); ?>

