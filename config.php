<?php 

	// DB Config
	$servername = "localhost";
	$username = "xotraffi_mvga_admin";
	$password = "";
	$dbname = "xotraffi_mvgaaa";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
?>
