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
	<script src="https://use.fontawesome.com/e8360da992.js"></script>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />

</head>
<?php
	require_once 'dbconnect.php';
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	$userId = $_SESSION['userId'];
	$firstName;
	$lastName;
	$userTypeDescription;
	
	$sql = "select firstName, lastName, userTypeDescription from accountSettings where id=" . $userId;
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	$row = $result->fetch_assoc();
	if($row['userTypeDescription'] != null){
		$userTypeDescription = $row['userTypeDescription'];
		$firstName = $row['firstName'];
		$lastName = $row['lastName'];
	}
	
	// Using Views findChildren and findParents
	$sql;
	if ($userTypeDescription == "Child"){
		// if you are a child user, find all the first, last, and id's of your parents
		$sql = "select parentFirstName as firstName, parentLastName as lastName, parentId as otherId from findParents where userId=" . $userId;
	} else {
		// if you are a parent user, find all the first, last, and id's of your children
		$sql = "select childFirstName as firstName, childLastName as lastName, childId as otherId from findChildren where userId=" . $userId;
	}

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}

	// Make an array out of result rows
	$relationshipRows = [];
	while($row = mysqli_fetch_array($result)){
	    $relationshipRows[] = $row;
	}
	
	
	
	$otherUserType;
	$pluralOtherType;
	
	// Set single and plural variables for other user type
	if ($userTypeDescription == "Parent"){
		$otherUserType = "Child";
		$pluralOtherType = "children";
		// You are a parent user type
	} else {
		$otherUserType = "Parent";
		$pluralOtherType = "parents";
		// You are a child user type
	}
	
	

?>
<body>
<!-- Begin banner -->
	<div >
		<div class="banner" id="peach">
			<span class="banner-text">View <?=ucfirst($otherUserType)?> Profiles</span>
		</div>
		<div class="instructions" id="light-grey">
			<span class="instructions-text">Whose profile would you like to view?</span>
		</div>
	</div>
<!-- End banner -->

<!-- Begin user profile page -->
<div class="container-fluid">

  <div>     
    <div class="light-text">
            <?php
                $items = array("blue", "yellow", "purple", "dark-teal");
                
            	if(count($relationshipRows) > 0){
			foreach($relationshipRows as $relation){
			    $profileUserId = $relation['otherId'];
			    $color = $items[array_rand($items)];
			    //echo "<div class='col-12'>" . $relation['firstName'] . " " . $relation['lastName'] . "</div>";
			    echo "<div class='row centerblock'>
					<div class='col-12 col-md-auto'>
					<div class='small-margin-top'>
  						<a class='btn btn-primary varela' id=" . $color . " href='viewOtherUserProfile.php?profileUserId=$profileUserId' style='color:white;'>" 
  						. $relation['firstName'] . " " . $relation['lastName'] . "</a>
  			    		</div></div></div>";
  			    $items = array_diff($items, array($color));
			}
			echo "<br>";
		} else {
			echo "<div style='margin-left:15px'>No " . $pluralOtherType . " found. Go to Account Settings to add your " . $pluralOtherType . ".</div>";
		}
	    ?>
    </div>
    
    
  </div>
<!-- End user profile page -->

<!-- Back button -->
  <div class="row centerblock">
    <div class="col-12 col-md-auto" style="margin-bottom: 30px;">
      <a class="btn btn-primary varela small-margin-top" id="light-teal" href="main.php">Back</a>
    </div>
  </div>
</div>
  

</body>
</html>
