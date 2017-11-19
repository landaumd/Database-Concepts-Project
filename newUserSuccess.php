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

<style>
/* Center the loader */
#loader {
  z-index: 1;
  width: 150px;
  height: 150px;
  margin-top: 200px;
  border-radius: 50%;
  border-top: 16px solid #96D4C9;
  border-right: 16px solid #E6E4E5;
  border-bottom: 16px solid #FFBF7A;
  border-left: 16px solid #FF9180;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
</style>
</head>
<body onload="loadWheel()" style="margin:0;">

<div class="centerblock" id="loader"></div>

<div style="display:none;" id="myDiv" class="animate-bottom">
<div >
<div class="banner" id="yellow">
<span class="banner-text">New user successfully created.</span>
</div>
<div class="instructions" id="light-grey">
<span class="instructions-text">Enter user information.</span>
</div>
</div>
<div class="small-margin-top">
<div class="container centerblock">
<div>

<form method="POST" action="addUser.php">

	<div class="form-group" style="margin-top: 5px;">
	<input type="text" placeholder="First name" class="form-control varela input-bubbles" name="firstName" required>
	</div>
	
	<div class="form-group small-margin-top">
	<input type="text" placeholder="Last name" class="form-control varela input-bubbles" name="lastName" required>
	</div>
	
	<div class="form-group small-margin-top">
      		<select class="custom-select varela" style="border-radius:20px;border:solid #E6E4E5;border-width:2px;height:42px;width:100%;" name="userType">
		  <option selected>Select user type</option>
		  <option value="1">Child</option>
		  <option value="2">Parent</option>
		</select>
	</div>
	
	<div class="form-group small-margin-top">
	<input type="number" placeholder="Age" class="form-control varela input-bubbles" name="age" required>
	</div>
	
	<div class="row centerblock">
	<div class="col-12 col-md-auto" style="margin-top: 5px; margin-bottom: 30px;">
	<button class="btn btn-primary varela" id="dark-teal" type="submit" name="submit">Submit</button>
	</div>
	</div>
</form>
  
</div>

<script>
var myVar;

function loadWheel() {
    myVar = setTimeout(showPage, 2000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
</script>

</body>
</html>
