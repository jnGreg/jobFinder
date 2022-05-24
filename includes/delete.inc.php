<?php 

if (isset($_POST["f_submit"])) {

	$user_id = $_POST["f_user_id"];

	require_once "config.inc.php";

	session_start(); 
	session_unset(); 
	session_destroy(); 

	$sql_delete_user = "DELETE FROM users WHERE user_id = $user_id;";
	mysqli_query($conn, $sql_delete_user);

	header("location: ../index.php");
	exit();



		