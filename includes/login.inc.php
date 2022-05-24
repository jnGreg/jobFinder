<?php 

if (isset($_POST["f_submit"])) {

	$username = $_POST["f_username"];
	$password = $_POST["f_password"];

	require_once "config.inc.php";
	require_once "functions.inc.php";

	if (emptyInputLogin($username, $password) !== false) {
		header("location: ../login.php?error=emptyinput");
		exit();
	}

	loginUser($conn, $username, $password);
}
else {
	header("location: ../login.php");
	exit();
}

