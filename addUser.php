<?php
	require_once 'dbconnect.php';

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	$userId;
	
	$userEmail = $_SESSION['userEmail'];
	$username = $_SESSION['username'];
	$userPassword = $_SESSION['userPassword'];
	
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$userType = $_POST['userType'];
	$age = $_POST['age'];
	echo $firstName . " " . $lastName . " " . $userType . " " . $age . " email = " . $userEmail;
	
	$sql = "INSERT INTO user(firstName, lastName, userType, age) VALUES ('" 
	. ucwords($firstName) . "', '" . ucwords($lastName) . "', '" . $userType . "', " . $age . ")";
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} 
	
	$sql = "select id from user where firstName='" . $firstName . "' and lastName='" . $lastName . "' and userType='" . $userType . "' and age=" . $age;
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	
	$row = $result->fetch_assoc();
	
	if($row['id'] != null){
		$userId = $row['id'];
	}
	
	echo "user id = " . $userId;
	
	$_SESSION['userId'] = $userId;
	
	
	$sql = "INSERT INTO login(userId, username, password) VALUES (" . $userId . ", '" . $username . "', '" . $userPassword . "')";

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} 
	
	$nullValue = null;

	$sql = "INSERT INTO contact(userId, phone, email) VALUES (" . $userId . ", '" . $nullValue . "', '" . $userEmail . "')";

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} 

	header("Location:main.php");
	
?>