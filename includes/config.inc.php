<?php
$serverName = "localhost";
$dBuserName = "username";
$dBpassword = "password";
$dBname = "jobfinder";

$conn = mysqli_connect($serverName, $dBuserName, $dBpassword, $dBname);

	if (!$conn) {
	  die("Connection failed: " . mysql_connect_error());
	}