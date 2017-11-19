<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Databases Project</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<!-- <script src="js/scripts.js"></script> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />

</head>


<body>
<?php
	require_once 'dbconnect.php';
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	$userId = $_SESSION['userId'];

	
	$sql = "select firstName, userType from user where id=" . $userId;
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	
	$row = $result->fetch_assoc();

	$firstName;
	$userTypeId;
	if($row['firstName'] != null){
		$firstName = $row['firstName'];
		$userTypeId = $row['userType'];
	}
	
	$sql = "select userType from userType where userTypeId=" . $userTypeId;
	
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	
	$row = $result->fetch_assoc();

	$userTypeDescription;
	if($row['userType'] != null){
		$userTypeDescription = $row['userType'];
	}
	
	$otherUserType;
	if ($userTypeDescription == "Parent"){
		$otherUserType = "Child";
	} else {
		$otherUserType = "Parent";
	}
	
	

?>
	<div >
		<div class="banner" id="light-teal">
			<span class="banner-text">Welcome back, <?=$firstName?>!</span>
		</div>
		<div class="instructions" id="light-grey">
			<span class="instructions-text"><?=$userTypeDescription?></span>
		</div>
	</div>
  	<div class="row centerblock">
		<div class="col-12 col-md-auto">
			<a class="btn btn-primary varela small-margin-top" id="blue" href="profile.php">View Your Profile</a>
		</div>
	</div>
	<div class="row centerblock">
		<div class="col-12 col-md-auto">
			<a class="btn btn-primary varela small-margin-top" id="peach" href="chooseViewProfile.php"><?=$otherUserType?> Profile</a>
		</div>
	</div>
	<div class="row centerblock">
		<div class="col-12 col-md-auto">
			<a class="btn btn-primary varela small-margin-top" id="purple" href="viewMessages.php">Messages</a>
		</div>
	</div>
	<div class="row centerblock">
		<div class="col-12 col-md-auto">
			<a class="btn btn-primary varela small-margin-top" id="yellow" href="accountSettings.php">Account Settings</a>
		</div>
	</div>
	<div class="row centerblock">
		<div class="col-12 col-md-auto" style="margin-bottom: 30px;">
			<a class="btn btn-primary varela small-margin-top" id="dark-teal" href="index.php">Log Out</a>
		</div>
	</div>

</body>
</html>
