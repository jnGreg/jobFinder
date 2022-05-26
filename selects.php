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
	<title>SELECTS</title>
	<link rel="Stylesheet" type= "text/css" href = "css/bootstrap.min.css" />
	<link rel="Stylesheet" type= "text/css" href = "css/style.css?version=1" />

</head>
<body>
	<header>
		<?php
		require_once "includes/header.inc.php"; ?>
	</header>

	<main>
		<center><br><br><br>
		<head><h2>selects</h2></head><br><br><br><br><br><br>
		
			<?php $sql = "SELECT * FROM offers WHERE ctgr_id = 2 AND experience_level = 'mid' AND workplace_type = 'office';"; 
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_array($result)) {
				$offer_id = $row['offer_id'];
				$workplace_types = $row['workplace_type'];
				$experience_levels = $row['experience_level'];
				?><h4><?php echo $offer_id . ' ['. $workplace_types .  '] ['. $experience_levels . ']'?></h4><?php  ; 
			}?>
			<br><br><br><br><br><br><br><br><br><br><br><br>
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


