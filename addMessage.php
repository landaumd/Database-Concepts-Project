<?php

	require_once 'dbconnect.php';

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$userId = $_SESSION['userId']; //sender id

	$receiverFirstName = $_POST['receiverFirstName'];
	$receiverLastName = $_POST['receiverLastName'];
	$hiddenReceiverId = $_POST['hiddenReceiverId']; //comes from Replying to messages, not creating new ones
	$message = $_POST['newMessage'];
	
	echo " new message = " . $message;
	
	// get receiver id from post
	$receiverId;
	if($hiddenReceiverId === null || $hiddenReceiverId === ''){ // new message
		$sql = "select id from user where firstName='" . $receiverFirstName . "' and lastName='" . $receiverLastName . "'";
		//echo " this is a new message";
		if (!$result = $mysqli->query($sql)) {
		    echo "Errno: " . $mysqli->errno . "</br>";
		    echo "Error: " . $mysqli->error . "</br>";
		    exit;
		}
		$row = $result->fetch_assoc();
		if($row['id'] != null){
			$receiverId = $row['id'];
		}
		
	} else { // reply message
		//echo " this is a reply\n";
		$receiverId = $hiddenReceiverId;
	}
	
	//echo " receiver= " . $receiverId;

	$sql = "INSERT INTO messages(senderId, receiverId, message) VALUES (" 
		. $userId . ", " . $receiverId . ", '" . $message . "')";
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("Location:viewMessages.php");
	}

?>