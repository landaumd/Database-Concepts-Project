<?php

	require_once 'dbconnect.php';

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$userId = $_SESSION['userId'];
	
	$sql = "DELETE from user where id=" . $userId;

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("Location:index.php");
	}

?>