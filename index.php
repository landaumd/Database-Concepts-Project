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

<body>

<div class="container centerblock">
   <div class="container-fluid">
	<div>
		<img class="welcome" alt="Welcome Image" src="images/welcome.png" />
	</div>
	<form method="POST" action="login.php">
		<div class="form-group small-margin-top">
			<input type="text" placeholder="Username" class="form-control varela input-bubbles" name="username" required>
		</div>
		<div class="form-group">
			<input type="password" placeholder="Password" class="form-control varela input-bubbles small-margin-top" name="password" required>
		</div>
		<div class="row centerblock">
			<div class="col-12 col-md-auto">
				<button type="submit" class="btn btn-primary varela" name="submit" style="margin-top: 5px;" margin-bottom: 30px;"" id="purple">Login</button>
			</div>
			<div class="row centerblock">
				<div class="col-12 col-md-auto">
					<a class="btn btn-primary varela small-margin-top" style="margin-bottom:30px;" id="peach" href="createnewuser.php">New User</a>
				</div>
			</div>
		</div>
	</form>
</div>
</div>

</body>
</html>
