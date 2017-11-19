<?php

	require_once 'dbconnect.php';

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	
	$userId = $_SESSION['userId'];
	$messageId = $_REQUEST['messageId'];
	$otherId = $_REQUEST['otherId'];
	
	//$sql = "delete from messages where id=". $messageId . " and (receiverId=" . $userId . " and senderId=" . $otherId . ") or (senderId=" . $userId . " and receiverId=" . $otherId . ")";
	$sql = "DELETE from messages where (senderId=" . $userId . " and receiverId=" . $otherId . ") or (senderId=" . $otherId . " and receiverId=" . $userId . ")";

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	} else {
	    header("Location:viewMessages.php");
	}

?>