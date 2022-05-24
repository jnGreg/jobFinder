<?php 

function emptyInputRegister($email, $username, $password, $password_repeat) {
	$result;
	if (empty($email) || empty($username) || empty($password) || empty($password_repeat)){
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidUsername($username) {
	$result;
	if (!preg_match("/^[a-zA-Z0-9]{5,20}$/", $username)){
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidEmail($email) {
	$result;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidPassword($password) {
	$result;
	$no = strlen ($password); 
	if ($no <8){
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function passwordMatch($password, $password_repeat) {
	$result;
	if ($password !== $password_repeat){
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function checkAcceptRules($accept_rules) {
	$result;
	if (!isset($accept_rules)){
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function userExistsUsrNm($conn, $username) {
	$sql = "SELECT * FROM users WHERE username = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../register.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}

	else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}

function userExistsEmail($conn, $email) {
	$sql = "SELECT * FROM users WHERE email = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../register.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}

	else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}

function createUser($conn, $email, $username, $password) {
	$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../register.php?error=stmtfailed");
		exit();
	}

	$pwd_hash = password_hash($password, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "sss", $username, $pwd_hash, $email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	header("location: ../login.php?error=none");
	exit();
}

function emptyInputLogin($username, $password) {
	$result;
	if (empty($username) || empty($password)){
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function userExists($conn, $username, $email) {
	$sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../login.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ss", $username, $email);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}

	else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}

function loginUser($conn, $username, $password){
	$userExists = userExists($conn, $username, $username); 

	if ($userExists === false) {
		header("location: ../login.php?error=wronglogin");
		exit();
	}

	$pwd_hashed = $userExists["password"];
	$check_psw = password_verify($password, $pwd_hashed); 

	if ($check_psw === false) {
		header("location: ../login.php?error=wronglogin");
		exit();
	}
	else if ($check_psw === true) {
		SESSION_START();
		$_SESSION["userid"] = $userExists["user_id"]; 
		$_SESSION["username"] = $userExists["username"]; 
		header("location: ../index.php");
		exit();
	}
}

function watchedExists($conn, $user_id, $offer_id) {
	$sql = "SELECT * FROM watched WHERE user_id = ? AND offer_id = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../offer.php?offer_id=$offer_id&error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ii", $user_id, $offer_id);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}

	else {
		$result = false;
		return $result;
	}
	mysqli_stmt_close($stmt);
}

function createWatched($conn, $user_id, $offer_id) {
	$sql_watch = "INSERT INTO watched (user_id, offer_id) VALUES (?,?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql_watch)) {
		header("location: ../offer.php?offer_id=$offer_id&error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ii", $user_id, $offer_id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	header("location: ../offer.php?offer_id=$offer_id&error=none");
	exit();
}