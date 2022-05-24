<?php 
include ('includes/config.inc.php');

$voivodeshipId = isset($_POST['voivodeshipId']) ? $_POST['voivodeshipId'] : 0;
$cityId = isset($_POST['cityId']) ? $_POST['cityId'] : 0;

$command = isset($_POST['get']) ? $_POST['get'] : "";

switch ($command) {

    case "city":
        $result1 = "<option disabled selected>Choose city...</option>";
        $statement = "SELECT * FROM cities WHERE voivodeship_id='$voivodeshipId' ORDER BY city;";
        $dt = mysqli_query($conn, $statement);

        while ($result = mysqli_fetch_array($dt)) {
            $result1 .= "<option value=" . $result['city_id'] . ">" . $result['city'] . "</option>";
        }
        echo $result1;
        break;
}
 exit(); ?>

