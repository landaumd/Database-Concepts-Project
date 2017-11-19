<?php

require_once 'dbconnect.php';

if(isset($_POST['submit'])){ 
	
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$uname = $_POST['username'];
	$pword = $_POST['password'];
		
	$sql = "select userId from login where username='" . $uname;
	$sql .= "' and password='" . $pword . "'";
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	
	$row = $result->fetch_assoc();

	$sessionUserId;
	
	if($row['userId'] != null){
		$sessionUserId = $row['userId'];
		
	}
	
	$_SESSION['userId'] = $sessionUserId;

	if($row['userId'] != null){
		header("Location:main.php");
	} else {
		// display error message
		$invalidMessage = "<div class='alert alert-dark' role='alert'>Invalid username or password.</div>";
		echo $invalidMessage;
	}
}

?>