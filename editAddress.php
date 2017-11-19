<?php

require_once 'dbconnect.php';

if(isset($_POST["submit"])) {

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$addressBlock = ucwords($_POST['editAddressBlock']);
	$city = ucwords($_POST['editCity']);
	$stateAbbreviation = $_POST['editStateAbbreviation'];
	$stateId;
	$postCode = $_POST['editPostCode'];
	$addressId = $_POST['editAddressId'];

	$userId = $_SESSION['userId'];
	
	$sql = "select id, abbreviation, stateName from state where abbreviation='" . $stateAbbreviation . "'";
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	$row = $result->fetch_assoc();
	if($row['abbreviation'] != null){
		$stateId = $row['id'];
		$stateAbbreviation = $row['abbreviation'];
		$stateName = $row['stateName'];
	}
	
	$description = nl2br($addressBlock . ",\n " . $city . ", " . $stateAbbreviation . " " . $postCode);
	
	echo "about to update";
	echo $addressId;
	$sql = "update address set 
	addressBlock='" . $addressBlock . 
	"', city='" . $city .
	"', stateId=" . $stateId .
	", countryId=" . 1 .
	", postCode=" . $postCode .
	", description='" . $description . 
	"' where userId=" . $userId . " and addressId=" . $addressId; 
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
		header("location:accountSettings.php");        
	}   			   
}

?>