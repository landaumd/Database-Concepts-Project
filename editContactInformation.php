<?php

require_once 'dbconnect.php';

if(isset($_POST["submit"])) {

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$userId = $_SESSION['userId'];
	
	if (!((bool) preg_match('/^\([0-9]{3}\)\s[0-9]{3}-[0-9]{4}/', $phone))){
		
		$sql = "select formatPhoneNumber(" . $phone . ",'(###) ###-####') as newPhone";
		if (!$result = $mysqli->query($sql)) {
		    echo "Errno: " . $mysqli->errno . "</br>";
		    echo "Error: " . $mysqli->error . "</br>";
		    exit;
		}
		$row = $result->fetch_assoc();
		if($row['newPhone'] != null){
			$phone = $row['newPhone'];
		}
	}
	
	
	$sql = "update contact set 
	email='" . $email . 
	"', phone='" . $phone . 
	"' where userId=" . $userId;
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
		header("location:accountSettings.php");        
	}   			   
}

?>