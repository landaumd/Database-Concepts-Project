<?php

	require_once 'dbconnect.php';

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$userId = $_SESSION['userId'];
	$userTypeDescription = $_REQUEST['userTypeDescription'];
	$otherId = $_REQUEST['otherId'];
	
	$sql;
	if ($userTypeDescription == "Child"){
		$sql = "delete from relationship where parentId=". $otherId . " and childId=" . $userId;
	} else {
		$sql = "delete from relationship where childId=". $otherId . " and parentId=" . $userId;
	}
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("Location:accountSettings.php");
	}

?>