<?php
require_once 'dbconnect.php';

if(isset($_POST["submit"])) {

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	$userId = $_SESSION['userId'];
	$shortBio = $_POST['shortBio'];
	$hometown = $_POST['hometown'];
	$age = $_POST['age'];
	
	$sql = "update user set 
	shortBio='" . $shortBio .
	"', hometown='" . $hometown .
	"', age=" . $age . " where id=" . $userId;
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("location:profile.php");        
	}   			   
}

?>