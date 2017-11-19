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
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round"/>

</head>

<body>
<?php
	require_once 'dbconnect.php';
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	$userId = $_SESSION['userId'];
	$firstName;
	$lastName;
	$username;
	$currentPassword;

	$userTypeId;
	$userTypeDescription;
	$otherUserType;
	$pluralOtherType;

	$addressId;
	$addressBlock;
	$city;
	$stateAbbreviation;
	$stateName;
	$postCode;
	$countryAbbreviation;
	$addressDescription;

	$phone;
	$email;

	$errorMessage = $_SESSION['errorMessage'];

	// Using View accountSettings
	$sql = "select
		    firstName,
		    lastName,
		    username,
		    currentPassword,
		    userTypeDescription,
		    addressId,
		    addressBlock,
		    city,
		    stateAbbreviation,
		    postCode,
		    countryAbbreviation,
		    countryName,
		    addressDescription,
		    email,
		    phone
		from accountSettings where id=" . $userId;

	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}
	$row = $result->fetch_assoc();
	if($row['firstName'] != null){
		$firstName = $row['firstName'];
		$lastName = $row['lastName'];
		$username = $row['username'];
		$currentPassword = $row['currentPassword'];
		$userTypeDescription = $row['userTypeDescription'];
		
		$addressId = $row['addressId'];
		$addressBlock = $row['addressBlock'];
		$city = $row['city'];
		$stateAbbreviation = $row['stateAbbreviation'];
		$postCode = $row['postCode'];
		$countryAbbreviation = $row['countryAbbreviation'];
		$countryName = $row['countryName'];
		$addressDescription = $row['addressDescription'];

		$phone = $row['phone'];
		$email = $row['email'];
	}

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

	// Save user type description for use on other pages
	$_SESSION['userTypeDescription'] = $userTypeDescription;

	//if ($addressBlock == null){
	//	$stateAbbreviation = null;
//		$postCode = null;
//		$countryAbbreviation = null;
//	}

	$sql = "select addressId, addressBlock, city, stateAbbreviation, postCode, addressDescription from accountSettings where
	addressId is not null and id=" . $userId;
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}

	// Make an array out of result rows
	$addressRows = [];
	while($row = mysqli_fetch_array($result)){
	    $addressRows[] = $row;
	}


?>
<!-- BEGIN BANNER -->
<div>
	<div class="banner" id="yellow">
		<span class="banner-text">My Account</span>
	</div>
	<div class="instructions" id="light-grey">
		<span class="instructions-text"><?=$userTypeDescription?></span>
	</div>
</div>
<!-- END BANNER -->
<!-- BEGIN MAIN CONTAINER -->
<div class="container-fluid">


<!-- BEGIN USER info display -->
  <div style="margin-top:20px;">
    <div>
  	  <div class="dark-text float-left">User Information</div>
      <div class="float-right centerblock" >
        <button type="button" class="btn btn-primary varela" style="width:50px;color:white;" id="dark-teal" data-toggle="modal" data-target="#userInformationModal">
        	<i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
	<br>
	<button type="button" class='btn btn-primary varela' style='width:50px;color:white;margin-top:10px;' id="peach" data-toggle="modal" data-target="#deleteUserModal">
		<i class='fa fa-user-times' aria-hidden='true'></i>
	</button>
  

      </div><br>
    </div>
    <div class="light-text" style="margin-left:15px;">

	<div class="row">
		<div class="col-4 float-left">
			Name:
			<br>
			Username:
		</div>
		<div class="col-8 float-right">
			<?=$firstName?> <?=$lastName?>
			<br>
			<?=$username?>
		</div>
    	</div>

    </div>
  </div>
<!-- END USER info display -->

<!-- BEGIN contact info display -->
  <div class="small-margin-top">
    <div style="padding-top:20px;">
      <div class="dark-text float-left" >Contact Information</div>
      <div class="float-right">
        <button type="button" class="btn btn-primary varela" style="width:50px;color:white;" id="dark-teal" data-toggle="modal" data-target="#contactInformationModal"><i class="fa fa-pencil" aria-hidden="true"></i></button>
      </div><br>
    </div>
    <div class="light-text" style="margin-left:15px;">

    	<div class="row">
		<div class="col-4 float-left">
			Email:
			<br>
			Phone:
			<br>
			Address:
		</div>
		<div class="col-8 float-right">
			<?=$email?>
			<br>
			<?=$phone?>
			<br>
			<?=$addressDescription?>
		</div>
    	</div>

    </div>
  </div>
<!-- END contact info display -->

<!-- BEGIN relationships display -->
  <div class="small-margin-top">
    <div>
      <div class="dark-text float-left"><?=ucfirst($pluralOtherType)?></div>
      <div class="float-right">
        <button type="button" class="btn btn-primary varela" style="width:50px;color:white;" id="dark-teal" data-toggle="modal" data-target="#parentChildRelationshipsModal"><i class="fa fa-pencil" aria-hidden="true"></i></button>
      </div><br>
    </div>
    <div class="light-text row">
            <?php
            	if(count($relationshipRows) > 0){
			foreach($relationshipRows as $relation){
			    echo "<div class='col-12'>" . $relation['firstName'] . " " . $relation['lastName'] . "</div>";
			}
		} else {
			echo "<div style='margin-left:15px'>No " . $pluralOtherType . " found.</div>";
		}

	    ?>

    </div>
  </div>

<!-- END relationships display -->



<!-- BEGIN Back Button -->
  <div class="row centerblock">
    <div class="col-12 col-md-auto" style="margin-bottom: 30px;">
      <a class="btn btn-primary small-margin-top varela" id="light-teal" style="color:white;" href="main.php">Back</a>
    </div>
  </div>
<!-- END back button -->


<!-- User Information Modal -->
  <div class="modal fade" id="userInformationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title varela" style="font-size:20px;font-weight:600;" id="exampleModalLabel">Edit User Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding-bottom:0px;">

          <form method="POST" action="editUserInformation.php">
          <div class="varela">User Information</div>
            <div class="form-group px-2">
              <label class="dark-text">First</label>
              <input type="text" class="form-control light-text" name="firstName" placeholder="<?=$firstName?>" value="<?php echo $firstName; ?>" required>
            </div>
            <div class="form-group px-2">
              <label class="dark-text">Last</label>
              <input type="text" class="form-control light-text" name="lastName" placeholder="<?=$lastName?>" value="<?php echo $lastName; ?>" required>
            </div>
            <hr>
            <div class="varela">Account Settings</div>
            <div class="form-group px-2">
              <label class="dark-text">Username</label>
              <input type="text" class="form-control light-text" name="username" placeholder="<?=$username?>" value="<?php echo $username; ?>" required>
            </div>
            <div class="form-group px-2">
              <label class="dark-text">Current password</label>
              <input type="password" class="form-control light-text" name="currentPassword" required>
            </div>
            <div class="form-group px-2">
              <label class="dark-text">New password</label>
              <input type="password" class="form-control light-text" name="newPassword" required>
            </div>


        </div>
        <div class="modal-footer" style=>
          <button type="button" class="btn btn-primary varela" id="light-teal" style="color:white;" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="dark-teal">Save</button>
        </div>
        </form>
     
    </div>
  </div>
</div>


<!-- Contact Information Modal -->

  <div class="modal fade" id="contactInformationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="">
        <div class="modal-header">
          <h5 class="modal-title varela" style="font-size:20px;font-weight:600;" id="exampleModalLabel">Edit Contact Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding-left:0px;padding-right:0px;">

<!-- BEGIN ADDRESS -->
          <div class="px-2">
                  <?php
			echo "<div class='px-2 varela'>Addresses</div>";
	
			if(count($addressRows) > 0){
				echo "<ul class='list-group'>";
	
				for ($i = 0; $i < count($addressRows); $i++) {
					$addressDescription = $addressRows[$i]['addressDescription'];
					$addressId = $addressRows[$i]['addressId'];
					$input = json_encode($addressRows[$i]);
				    	echo "<li class='list-group-item d-flex justify-content-between align-items-center light-text' style='border:0;padding-left:10px;padding-right:10px'>"
				    		. $addressDescription .
				    		"<div class='float-right'>
				    			<span class='btn' style='background-color:#FFBF7A;border-radius:20px;width:50px;'>
				    				<a data-toggle='collapse' href='#collapseEditAddress' onclick='editAddress(" . $input . ")'>
				    				<i class='fa fa-pencil' style='font-size:18px;color:white;' aria-hidden='true'></i>
				    				</a>
				    			</span>
				  			<span class='btn' style='background-color:#FF9180;border-radius:20px;width:50px;'>
				  				<a href='deleteAddress.php?addressId=$addressId'>
				  					<i class='fa fa-user-times' style='font-size:18px;color:white;' aria-hidden='true'></i>
				  				</a>
				  			</span>
				  		</div>
				  		</li>";
				}
	
				echo "<li class='list-group-item d-flex justify-content-between align-items-center light-text' style='border:0;padding-left:10px;padding-right:10px'>
				    		Add a new address
				    		<span class='btn' style='background-color:#5BB9A7;border-radius:20px;width:50px;'>
				    			<a data-toggle='collapse' href='#collapseAddNewAddress'>
				    				<i class='fa fa-user-plus' style='font-size:18px;color:white;' aria-hidden='true'></i>
				    			</a>
				    		</span>
				      </li>";
				echo "</ul>";
			} else {
				echo "<div class='px-2 light-text' style='margin-left:15px'>No addresses found.</div>";
				echo "<li class='list-group-item d-flex justify-content-between align-items-center light-text' style='border:0;padding-left:10px;padding-right:10px'>
				    		Add a new address
				    		<span class='btn' style='background-color:#5BB9A7;border-radius:20px;width:50px;'><a data-toggle='collapse' href='#collapseAddNewAddress'><i class='fa fa-user-plus' style='font-size:18px;color:white;' aria-hidden='true'></i></a></span>
				      </li>";
				echo "</ul>";
			}
			
		    ?>  
<!-- BEGIN add address -->
	  <form method="POST" action="addAddress.php">
            <div class="collapse container-fluid" id="collapseAddNewAddress" style="background-color:#E6E4E5;padding-top:10px;padding-bottom:10px;">
	            <div class="row">
		            <div class="col-10 varela float-left">
		            	Add a new address
		            </div>
		    </div>

            <div class="form-group">
              <label class="dark-text">Number and street</label>
              <input type="text" class="form-control light-text" name="addressBlock" placeholder="<?php echo $a['addressBlock'];?>" value="<?php echo $a['addressBlock']; ?>" required>
            </div>
            <div class="form-group">
              <label class="dark-text">City</label>
              <input type="text" class="form-control light-text" name="city" required>
            </div>
            <div class="row">
              <div class="float-left form-group col-4">
                <label class="dark-text">State</label>
                <input type="text" class="form-control light-text" style="text-transform: uppercase;" name="stateAbbreviation" required>
              </div>
              <div class="float-right form-group col-8">
                <label class="dark-text">Zip code</label>
                <input type="text" class="form-control light-text" name="postCode" minlength="5" maxlength="5" required>
              </div>
          </div> 
          <div class="centerblock">
          	<button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="purple">Save</button>
          </div>
        </div>
        </form>
<!-- END add address -->
<!-- BEGIN edit address -->
	<form method="POST" action="editAddress.php">
            <div class="collapse container-fluid" id="collapseEditAddress" style="background-color:#E6E4E5;padding-top:10px;padding-bottom:10px;">
	            <div class="row">
		            <div class="col-10 varela float-left">
		            	Edit address
		            </div>
		    </div>
            <div class="form-group">
              <label class="dark-text">Number and street</label>
              <input type="text" class="form-control light-text" name="editAddressBlock" id="editAddressBlock" required>
            </div>
            <div class="form-group">
              <label class="dark-text">City</label>
              <input type="text" class="form-control light-text" name="editCity" id="editCity" required>
            </div>
            <div class="row">
              <div class="float-left form-group col-4">
                <label class="dark-text">State</label>
                <input type="text" class="form-control light-text" style="text-transform: uppercase;" name="editStateAbbreviation" id="editStateAbbreviation" required>
              </div>
              <div class="float-right form-group col-8">
                <label class="dark-text">Zip code</label>
                <input type="text" class="form-control light-text" name="editPostCode" id="editPostCode" minlength="5" maxlength="5" required>
              </div>
          </div>
          <div class="form-group">
              <input type="hidden" name="editAddressId" id="editAddressId"/>
          </div>
          <div class="centerblock">
          	<button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="purple">Save</button>
          </div>
        </div>
        </form>
<!-- END edit address -->
</div>
<!-- END ADDRESS -->

<!-- BEGIN Email and Phone -->
	<div class="px-2 container-fluid">
          <form class="px-2" method="POST" action="editContactInformation.php">
            <hr>
            <div class="varela" style="padding-bottom:10px;">Email</div>
            <div class="form-group px-2">
              <input type="email" class="form-control light-text" name="email" placeholder="<?php echo $email;?>" value="<?php echo $email; ?>" required>
            </div>
            <hr>
            <div class="varela" style="padding-bottom:10px;">Phone number</div>
            <div class="form-group px-2">
              <input type="text" class="form-control light-text" name="phone" minlength="10" maxlength="10" placeholder="<?php echo $phone;?>" value="<?php echo $phone; ?>" required>
            </div>
	  </div>
	</div>
<!-- END Email and Phone -->


<!-- BEGIN footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary varela" style="color:white;" id="light-teal" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="dark-teal">Save</button>
        </div>
        </form>
<!-- END footer -->

      
    </div>
  </div>
</div>
</div>
<!-- END contact info modal -->

<!-- Parent-Child Relationships Modal -->

  <div class="modal fade" id="parentChildRelationshipsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title varela" style="font-size:20px;font-weight:600;">Edit Relationships</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="POST" action="addRelationship.php">

          <?php
		echo "<div class='varela'>Your " . $pluralOtherType . "</div>";
		if(count($relationshipRows) > 0){
			echo "<ul class='list-group'>";
			foreach($relationshipRows as $relation){
				$otherId = $relation['otherId'];
			    
			    echo "<li class='list-group-item d-flex justify-content-between align-items-center light-text' style='margin-top:10px;border:0;'>"
			    	. $relation['firstName'] . " " . $relation['lastName'] .
			    	"<span class='btn' style='background-color:#FF9180;border-radius:20px;width:50px;'><a href='deleteRelationship.php?otherId=$otherId&userTypeDescription=$userTypeDescription'><i class='fa fa-user-times' style='font-size:18px;color:white;' aria-hidden='true'></i></a></span>
			  	</li>";
			    
			}
			echo "</ul>";
		} else {
			echo "<div class='light-text' style='margin-left:15px'>No " . $pluralOtherType . " found.</div>";
		}

	    ?>
            <hr>
            <div class="row small-margin-top">
	            <div class="col-10 varela float-left">
	            	Add a new <?php echo strtolower($otherUserType); ?>
	            </div>

	    </div>

            <div class="form-group small-margin-top px-2">
              <input type="text" class="form-control light-text" name="addFirstName" placeholder="First name" required>
            </div>
            <div class="form-group small-margin-top px-2">
              <input type="text" class="form-control light-text" name="addLastName" placeholder="Last name" required>
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary varela" style="color:white;" id="light-teal" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="dark-teal">Add  <i class='fa fa-user-plus' style='color:white;' aria-hidden='true'></i></button>
        </div>
        </form>

      </div>
    </div>
  </div>

<!-- END Parent-Child Relationships Modal -->



<!-- BEGIN Delete User Modal -->

  <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title varela" style="font-size:20px;font-weight:600;">Delete User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="POST" action="deleteUser.php">
          <div class="container-fluid centerblock">
            <div class="varela" style="margin-top:20px;margin-bottom:20px;">
            	Are you sure you want to delete your account?
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary varela" style="color:white;" id="light-teal" data-dismiss="modal">No</button>
          <button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="peach">Yes</button>
        </div>
        </form>

      </div>
    </div>
  </div>
  



</div>
<!-- END MAIN CONTAINER -->

<script>
function editAddress(a){
    //console.log(a);
    //console.log(a.addressId);
    document.getElementById("editAddressBlock").placeholder = a.addressBlock;
    document.getElementById("editCity").placeholder = a.city;
    document.getElementById("editStateAbbreviation").placeholder = a.stateAbbreviation;
    document.getElementById("editPostCode").placeholder = a.postCode;
    document.getElementById("editAddressId").placeholder = a.addressId;
    
    document.getElementById("editAddressBlock").value = a.addressBlock;
    document.getElementById("editCity").value = a.city;
    document.getElementById("editStateAbbreviation").value = a.stateAbbreviation;
    document.getElementById("editPostCode").value = a.postCode; 
    document.getElementById("editAddressId").value = a.addressId; 
}


</script>

</body>
</html>
