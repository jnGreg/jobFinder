<?php 
include ('config.inc.php');

if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$sql = "SELECT * FROM cities WHERE voivodeship_id = '$id' ORDER BY city;"; 
	$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_array($result)){ 
			?><option value="<?php echo $row["city_id"];?>"><?php echo $row["city"];?></option><?php }
			
}
