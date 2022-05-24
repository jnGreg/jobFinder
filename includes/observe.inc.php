
<?php


session_start(); 

if (isset ($_POST['f_submit'])) {
	$user_id = $_SESSION['userid'];
	$offer_id = $_POST['f_offer_id']; 

	require_once ('config.inc.php');
	require_once('functions.inc.php');

	if (watchedExists($conn, $user_id, $offer_id) !== false) {
		header("location: ../offer.php?offer_id=$offer_id&error=alreadywatched");
		exit();
	}

	createWatched($conn, $user_id, $offer_id);
}

else {
	header("location: ../offer.php?offer_id=$offer_id");
	exit();
}