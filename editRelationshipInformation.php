<?php
require_once 'dbconnect.php';

if(isset($_POST["submit"])) {

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$currentPassword = $_POST['currentPassword'];
	$newPassword = $_POST['newPassword'];
	$username = $_POST['username'];
	$firstName = ucfirst($_POST['firstName']);
	$lastName = ucfirst($_POST['lastName']);
	$userId = $_SESSION['userId'];
	echo $firstName;
	echo "here";
	$sql = "update login set 
	password='" . $newPassword . "'," .
	"username='" . $username . "'" .
	" where userId=" . $userId . 
	" and password='" . $currentPassword . "'";

	  
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    $_SESSION['errorMessage'] = "Username and password not updated: Invalid input.";
	    exit;
	} 
	
	$sql = "update user set 
	firstName='" . $firstName .
	"', lastName='" . $lastName .
	"' where id=" . $userId;
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
		
	    header("location:accountSettings.php");        
	}   			   
}

?>