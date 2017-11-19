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
<div >
<div class="banner" id="peach">
<span class="banner-text">Create a new user account!</span>
</div>
<div class="instructions" id="light-grey">
<span class="instructions-text">Enter a username and password.</span>
</div>
</div>
<div class="small-margin-top">
<div class="container centerblock">
<div>

<form method="POST" action="createNewUser.php">

<div class="form-group" style="margin-top: 5px;">
<input type="text" placeholder="Username" class="form-control varela input-bubbles" name="username" required>
</div>

<div class="form-group small-margin-top">
<input type="email" placeholder="Email address" class="form-control varela input-bubbles" name="email" required>
</div>

<div class="form-group small-margin-top">
<input type="password" placeholder="Password" class="form-control varela input-bubbles" name="password" required>
</div>

<div class="form-group small-margin-top">
<input type="password" placeholder="Confirm password" class="form-control varela input-bubbles" name="confirmpassword" required>
</div>

<div class="row centerblock">
<div class="col-12 col-md-auto" style="margin-top: 5px; margin-bottom: 30px;">
<button class="btn btn-primary varela" id="purple" type="submit" name="submit">Create New User</button>
</div>
</div>
</form>

</div>
</div>


</body>
</html>
