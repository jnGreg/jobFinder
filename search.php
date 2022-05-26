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
	<title>Browse offers</title>
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
		<div id = "container_search"> <br><br><br><br><h4> Narrow down your results or look for something else </h4> <br>
			<form class="form-inline" method="GET" action=""><div style="padding: 10px;">
						<input hidden name = "view" value = "<?php if(isset($_GET['view'])) { echo $_GET['view']; } else { echo "list"; }?>"> <div style="width: 1000px;">
						<input class="form-control mr-1" type="search" placeholder="Keywords..." aria-label="wyszukaj" id = "item" name = "k" autocomplete="off" style="width:700px;" maxlength=75 minlength=3 required value="<?php if(isset($_GET['k'])&& $_GET['k'] != '') { echo $_GET['k']; } else { echo ""; } ?>"></div>
						
							<div class="form-group" style="padding: 8px; width:450px; display: block; float:left;"> 
				<select class="form-control" id="category" name="ctgr" style="width:210px;">
					<option selected value="">Main Category...</option>
					<?php 
						$sql = "SELECT * FROM ctgrs;";
						$result = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_array($result)){ 
								?><option value="<?php echo $row["ctgr_id"];?>"><?php echo $row["category"];?></option><?php
							}	
					?>
				</select>
					</div>
					<div class="form-group" style="padding: 8px; width:450px; display: block; float:left;"> 
						<select class="form-control" id="voivodeship" name="voivodeship" style="width:210px;">
							<option value="" selected>Poland...</option>
						<?php 
							$sql = "SELECT * FROM voivodeships;";
							$result = mysqli_query($conn, $sql);
								while($row = mysqli_fetch_array($result)){ 
									?><option value="<?php echo $row["voivodeship_id"];?>"><?php echo $row["voivodeship"];?></option><?php
								}	
						?>
						</select>
						<select class="form-control" id="city" name="city" style="width:210px;"> 
						<option value="" disabled selected>City...</option>
							
						</select></div>
						<button class="btn btn-success" type="submit">Search </button></div>
						</form></div>
			<br><br><br><br>
			<h2> Filter results </h2> <br>
		<div id = "right_flank" style=" min-height: 450px;">
			<div style="padding-left: 15px; padding-right: 10px; display:inline-flex;">
				<form action="" method="get" style="float:left;">
				<div style="display:inline-flex;">
				<input hidden name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ""; ?>">
				<input hidden name="voivodeship" value="<?php echo isset($_GET['voivodeship']) ? $_GET['voivodeship'] : ""; ?>">
				<input hidden name="city" value="<?php echo isset($_GET['city']) ? $_GET['city'] : ""; ?>">
				<input hidden name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : ""; ?>">
				<input hidden name="ctgr" value="<?php echo isset($_GET['ctgr']) ? $_GET['ctgr'] : ""; ?>">
				<input hidden name="workplace_type" value="<?php echo isset($_GET['workplace_type']) ? $_GET['workplace_type'] : ""; ?>">
				<input hidden name="experience_level" value="<?php echo isset($_GET['experience_level']) ? $_GET['experience_level'] : ""; ?>">
					<button class="form-control mr-1" id = "gallery-view" name = "view" value="gallery" type="submit"> 
						<img src = "img/gallery-icon.png" height="25px" width="25px"> </button>
						<button class="form-control mr-1" id = "list-view" name = "view" value="list" type="submit">
							<img src = "img/list-icon.png" height="25px" width="25px"> </button>
						</div></form>
						
			<form class="form-inline" method="GET" action="" id="filtrowanie" style="margin-left: 350px;">
				<input hidden name="view" value="<?php echo $_GET['view']; ?>">
				<input hidden name="k" value="<?php echo isset($_GET['k']) ? $_GET['k']: ""; ?>">
				<input hidden name="voivodeship" value="<?php echo isset($_GET['voivodeship']) ? $_GET['voivodeship'] : ""; ?>">
				<input hidden name="city" value="<?php echo isset($_GET['city']) ? $_GET['city'] : ""; ?>">
				<input hidden name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : ""; ?>">
				<input hidden name="ctgr" value="<?php echo isset($_GET['ctgr']) ? $_GET['ctgr'] : ""; ?>">

				<div style="padding-left: 5px;">
				<select class="custom-select" id="inputExp" name="experience_level" style="margin-left:225px;">
					<option value="" selected >Experience level</option>
					<option value="junior">Junior</option>
		          	<option value="mid">Mid</option>
		          	<option value="senior">Senior</option>
				</select>
				<select class="custom-select" id="inputType" name="workplace_type">
					<option value="" selected >Work Type</option>
					<option value="remote">Fully Remote</option>
		          	<option value="partly_remote">Hybrid</option>
		          	<option value="office">Office</option>
				</select>
				<button class="btn btn-primary" type="submit">Filter</button> </div>
			</form>

						<form id ="sort-form" class="form-inline" method="GET" action="" style="margin-left: 380px;">
							<input hidden name="view" value="<?php echo $_GET['view']; ?>">
							<input hidden name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ""; ?>">
							<input hidden name="voivodeship" value="<?php echo isset($_GET['voivodeship']) ? $_GET['voivodeship'] : ""; ?>">
							<input hidden name="city" value="<?php echo isset($_GET['city']) ? $_GET['city'] : ""; ?>">
							<input hidden name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : ""; ?>">
							<input hidden name="ctgr" value="<?php echo isset($_GET['ctgr']) ? $_GET['ctgr'] : ""; ?>">
							<input hidden name="workplace_type" value="<?php echo isset($_GET['workplace_type']) ? $_GET['workplace_type'] : ""; ?>">
							<input hidden name="experience_level" value="<?php echo isset($_GET['experience_level']) ? $_GET['experience_level'] : ""; ?>">
							<select class="custom-select" id="inputSort" name="order">
								<option value="published_at DESC" selected>Newest</option>
								<option value="published_at ASC">Oldest</option>
								
							</select>

							<button class="btn btn-success" type="submit">Sort </button> 
						</form> </div><br><br><br><br>
					
						
						<?php $results_per_page = 32;

						if ($_GET["view"] == "list") { ?>
							<center>
						<section class = "offers">
							<?php 
							$sql = "SELECT * FROM offers WHERE ";
							if (isset ($_GET['k']) && $_GET['k'] != ''){
								$k = trim($_GET['k']);
								$keywords = explode(' ', $k);
								foreach ($keywords as $word) {
									$sql .= " title LIKE '%".$word."%' OR ";
								}
								$sql = substr($sql, 0, strlen($sql) - 3);
							}
							if (isset ($_GET['voivodeship']) && $_GET['voivodeship'] != ''){
								if (substr($sql, -6) === "WHERE "){
									$sql .= " voivodeship_id = ".$_GET['voivodeship']." "; }
								else { $sql .= " AND voivodeship_id = ".$_GET['voivodeship']." "; }
							}

							if (isset ($_GET['city']) && $_GET['city'] != ''){
								$sql .= " AND city_id = ".$_GET['city']." ";
							}
							
							if (isset ($_GET['ctgr']) && $_GET['ctgr'] != ''){
								if (substr($sql, -6) === "WHERE "){
									$sql .= " ctgr_id = ".$_GET['ctgr']." "; }
								else { $sql .= " AND ctgr_id = ".$_GET['ctgr']." "; }
							}

							if (isset ($_GET['workplace_type']) && $_GET['workplace_type'] != ''){
								if (substr($sql, -6) === "WHERE "){
									$sql .= " workplace_type = '".$_GET['workplace_type']."' "; }
								else { $sql .= " AND workplace_type = '".$_GET['workplace_type']."' "; }
							}

							if (isset ($_GET['experience_level']) && $_GET['experience_level'] != ''){
								if (substr($sql, -6) === "WHERE "){
									$sql .= " experience_level = '".$_GET['experience_level']."' "; }
								else { $sql .= " AND experience_level = '".$_GET['experience_level']."' "; }
							}

							if (isset ($_GET['order']) && $_GET['order'] != ''){
								$sql .= " ORDER BY ".$_GET['order']." ";
							}
							else { $sql .= " ORDER BY published_at DESC "; } 	

							$result = mysqli_query($conn, $sql);
							$number_of_results = mysqli_num_rows($result);

							if ($number_of_results === 0) {
								echo "<br><br><br><br><br><h2>No results found.</h2>";
							}

							$number_of_pages = ceil($number_of_results / $results_per_page);
							if (!isset ($_GET['page'])){
								$page = 1;
							} else {
								$page = $_GET['page'];
							}
							$first_result = ($page-1)*$results_per_page;
							$sql .= " LIMIT " . $first_result . ',' . $results_per_page;
							
							$result = mysqli_query($conn, $sql);

							while($row = mysqli_fetch_array($result)) {

								$offer_id = $row['offer_id'];
								$offer_ids[$offer_id] = $row['offer_id'];
								$jj_ids[$offer_id] = $row['jj_id'];
								$company_names[$offer_id] = $row['company_name'];
								$titles[$offer_id] = $row['title'];
								$workplace_types[$offer_id] = $row['workplace_type'];
								$experience_levels[$offer_id] = $row['experience_level'];
								$ctgr_ids[$offer_id] = $row['ctgr_id'];
								$add_dates[$offer_id] = $row['published_at'];
								$photos[$offer_id] = $row['company_logo_url'];
								$cities[$offer_id] = $row['city'];
								$friendly[$offer_id] = $row['open_to_hire_ukrainians'];
								
								?>
								<article class = "offer"> 
								<div style="width: 1200px; height: 120px; display: inline-flex;">
								<a style="width: 120px; height: 120px;  display: flex; align-items: center; justify-content: center;" href="offer.php?offer_id=<?php echo $offer_ids[$offer_id]; ?>" class = "artykul_zdjecie">
								<img src="<?php echo $photos[$offer_id]?>" style="max-width: 120px; max-height: 120px;"></a>
								
								<a href="offer.php?offer_id=<?php echo $offer_ids[$offer_id]; ?>" style="padding-left: 30px; width: 750px; font-size: 21px;" class = "artykul_nazwa"> <?php echo $titles[$offer_id]; ?><br><br><aside><p style="color:darkgreen;"><?php 
								echo $company_names[$offer_id] . ",&nbsp&nbsp" . $cities[$offer_id]. ",&nbsp&nbsp" . $workplace_types[$offer_id];
								if ($workplace_types[$offer_id] == 'remote') { ?> 
								<img style='margin-left: 5px;' src = "img/home.png" height="25px" width="25px"> <?php }
								if ($friendly[$offer_id] == 1) { ?> 
								<img style='margin-left: 5px;' src = "img/ukr.png" height="25px" width="25px"> <?php } ?></p>
							</aside>
							</a> 
							<p style="text-align: left;">Added:&nbsp
							<?php echo $add_dates[$offer_id]; ?></p>

							</div> 
								<aside class = "from_to" style="color:black; text-align: right; font-size: 18px;"><?php 
								$query_empl = "SELECT * FROM employment WHERE jj_id = '$jj_ids[$offer_id]';";
										$results_empl = mysqli_query($conn, $query_empl); 
										while($row = mysqli_fetch_array($results_empl)) {
										$empl_type = $row['type'];
										$min = $row['from'];
										$max = $row['to'];
										$currency = $row['currency'];
														echo $empl_type . ': ' . $min . ' - '. $max  . ' ' . $currency;
														?><br><?php  }
								 ?> 
								<p style="text-align: left;">
									<h5 style='color: <?php if ($experience_levels[$offer_id] == 'senior'){ echo 'red';}
								else if ($experience_levels[$offer_id] == 'mid') {echo 'blue';} else { echo 'green'; } ?> '> <?php echo 
									$experience_levels[$offer_id]; ?> </h5></p>
									</aside>
							</article> 

							<br>
							<?php } if($number_of_results >0) {?>
							<p>Page: <?php echo $page; ?>.<br>Go to: <?php for ($page=1; $page<=$number_of_pages; $page++){
								$k = isset($_GET['k']) ? $_GET['k'] : "";
								$ctgr = isset($_GET['ctgr']) ? $_GET['ctgr'] : "";
								$voivodeship = isset($_GET['voivodeship']) ? $_GET['voivodeship'] : "";
								$city = isset($_GET['city']) ? $_GET['city'] : "";
								$workplace_type = isset($_GET['workplace_type']) ? $_GET['workplace_type'] : "";
								$experience_level = isset($_GET['experience_level']) ? $_GET['experience_level'] : "";
								$order = isset($_GET['order']) ? $_GET['order'] : "";
							echo '<a href="search.php?view=' . $_GET['view'] . '&page=' . $page . '&k=' . $k .'&ctgr=' . $ctgr .'&voivodeship=' . $voivodeship .'&city=' . $city .'&workplace_type=' . $workplace_type .'&experience_level=' . $experience_level . '&order=' . $order .'">' . $page . " " .'</a>'; } ?> </p> <?php } ?>
							

						</section> </center><?php } 

						else if ($_GET["view"] == "gallery") { ?><br><br>
							<h2><center> Sorry bud, devs too lazy </center></h2>
						<?php } ?></div> 
				</div> 

			</main>
			<footer> 
				<?php
						require_once "includes/footer.inc.php"; ?>
			</footer>

			<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
			<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script type="text/javascript" src="js/jquery.js">  </script>
		</body>

		</html>


