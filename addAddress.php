<?php

	$mysqli = new mysqli('127.0.0.1', 'meganl33_admin', 'boodle', 'meganl33_project');

	if ($mysqli->connect_errno) {
	    echo "Errno: " . $mysqli->connect_errno . "</br>";
	    echo "Error: " . $mysqli->connect_error . "</br>";
	    exit;
	};

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$userId = $_SESSION['userId'];
	$userTypeDescription = $_SESSION['userTypeDescription'];
	$addressBlock = $_POST['addressBlock'];
	$city = $_POST['city'];
	$stateAbbreviation = $_POST['stateAbbreviation'];
	$stateId;
	$postCode = $_POST['postCode'];
	$countryAbbreviation = "USA";
	$countryId;
	$description;
	
	$sql = "CALL getStateIdFromAbbreviation('" . $stateAbbreviation . "')";
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	$row = $result->fetch_assoc();
	if($row['id'] != null){
		$stateId = $row['id'];		

	}

	$mysqli = new mysqli('127.0.0.1', 'meganl33_admin', 'boodle', 'meganl33_project');

	if ($mysqli->connect_errno) {
	    echo "Errno: " . $mysqli->connect_errno . "</br>";
	    echo "Error: " . $mysqli->connect_error . "</br>";
	    exit;
	}
	
	$sql = "CALL getCountryIdFromAbbreviation('" . $countryAbbreviation . "')";
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	$row = $result->fetch_assoc();
	if($row['id'] != null){
		$countryId = $row['id'];
	}
	
	$mysqli = new mysqli('127.0.0.1', 'meganl33_admin', 'boodle', 'meganl33_project');

	if ($mysqli->connect_errno) {
	    echo "Errno: " . $mysqli->connect_errno . "</br>";
	    echo "Error: " . $mysqli->connect_error . "</br>";
	    exit;
	}

	$description = nl2br($addressBlock . ",\n " . $city . ", " . $stateAbbreviation . " " . $postCode);
	
	$sql = "INSERT INTO address(userId, addressBlock, city, stateId, postCode, countryId, description) 
		VALUES (" . $userId . ",'" . $addressBlock . "','" . $city . "'," . $stateId . "," . $postCode . "," . $countryId . ",'" . $description . "')"; 

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("Location:accountSettings.php");
	}

?>