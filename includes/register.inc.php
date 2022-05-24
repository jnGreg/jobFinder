<?php


if (isset($_POST["f_submit"])) {

	$email = $_POST["f_email"];
	$username = $_POST["f_username"];
	$password = $_POST["f_password"];
	$password_repeat = $_POST["f_password_repeat"];
	$accept_rules = $_POST["f_accept_rules"];
	
	require_once('config.inc.php');
	require_once('functions.inc.php');

	if (emptyInputRegister($email, $username, $password, $password_repeat) !== false) {
		header("location: ../register.php?error=emptyinput");
		exit();
	}

	if (invalidUsername($username) !== false) {
		header("location: ../register.php?error=invalidusername");
		exit();
	}

	if (invalidEmail($email) !== false) {
		header("location: ../register.php?error=invalidemail");
		exit();
	}

	if (invalidPassword($password) !== false) {
		header("location: ../register.php?error=invalidpassword");
		exit();
	}

	if (passwordMatch($password, $password_repeat) !== false) {
		header("location: ../register.php?error=passwordsdontmatch");
		exit();
	}

	if(checkAcceptRules($accept_rules) !== false) {
		header("location: ../register.php?error=rulesnotaccepted");
		exit();
	}


	if (userExistsUsrNm($conn, $username) !== false) {
		header("location: ../register.php?error=usernametaken");
		exit();
	}

	if (userExistsEmail($conn, $email) !== false) {
		header("location: ../register.php?error=emailtaken");
		exit();
	}

	createUser($conn, $email, $username, $password);
	
}
else {
	header("location: ../register.php");
	exit();
}