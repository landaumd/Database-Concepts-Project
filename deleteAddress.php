<?php

	require_once 'dbconnect.php';

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$userId = $_SESSION['userId'];
	$addressId = $_REQUEST['addressId'];
	//echo $addressId;
	
	$sql = "delete from address where addressId=" . $addressId . " and userId=" . $userId;

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("Location:accountSettings.php");
	}

?>