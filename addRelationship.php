<?php

	require_once 'dbconnect.php';

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$userId = $_SESSION['userId'];
	$userTypeDescription = $_SESSION['userTypeDescription'];
	$addFirstName = $_POST['addFirstName'];
	$addLastName = $_POST['addLastName'];
	
	$sql;
	if ($userTypeDescription == "Child"){
		$sql = "INSERT INTO relationship(childId, parentId) SELECT " . $userId . ", id FROM user WHERE firstName='" . $addFirstName . "' and lastName='" . $addLastName . "'"; 
	} else {
		$sql = "INSERT INTO relationship(childId, parentId) SELECT id, " . $userId . " FROM user WHERE firstName='" . $addFirstName . "' and lastName='" . $addLastName . "'";
	}
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("Location:accountSettings.php");
	}

?>