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

	// Using view findMessages
	$sql = "SELECT 
		    messageId,
		    receiverId,
		    senderId, 
		    senderFirstName, 
		    senderLastName, 
		    message 
		from findMessages
		inner join 
		(select max(messageId) as maxId from findMessages group by senderId) as m on m.maxId=messageId
		and receiverId=" . $userId . 
		" order by messageId desc";

	//$sql = "SELECT max(messageId) as mostRecentMessageId, senderId, senderFirstName, senderLastName, message FROM `findMessages` WHERE receiverId=" . $userId . " group by senderId order by mostRecentMessageId desc";
	if (!$result = $mysqli->query($sql)) {
	    echo "Errno: " . $mysqli->errno . "</br>";
	    echo "Error: " . $mysqli->error . "</br>";
	    exit;
	}

	// Make an array out of result rows
	$messageRows = [];
	while($row = mysqli_fetch_array($result)){
	    $messageRows[] = $row;
	}	

?>
<body>
<!-- Begin banner -->
	<div >
		<div class="banner" id="purple">
			<span class="banner-text">Messages</span>
		</div>
		<div class="instructions" id="light-grey">
			<span class="instructions-text">Inbox</span>
		</div>
	</div>
<!-- End banner -->

<!-- Begin messages display -->
<div class="container-fluid small-margin-top">

  <div style="margin-top:20px;">
    <div class="light-text">
                  <?php	
			if(count($messageRows) > 0){
				echo "<ul class='list-group'>";
	
				for ($i = 0; $i < count($messageRows); $i++) {
					$messageSenderFirstName = $messageRows[$i]['senderFirstName'];
					$messageSenderLastName = $messageRows[$i]['senderLastName'];
					$message = $messageRows[$i]['message'];
					$messageId = $messageRows[$i]['messageId'];
					$otherId = $messageRows[$i]['senderId'];
					$input = json_encode($messageRows[$i]);
					
				    	echo "<li class='list-group-item d-flex justify-content-between align-items-center dark-text' style='border:0;padding-left:10px;padding-right:10px'>
				    		<div class='float-left'>
				    			<div>" 
				    			. $messageSenderFirstName . " " . $messageSenderLastName .
				    			"</div>
				    			<div class='light-text'>"
				    			. substr($message, 0, 12) . "..." .
				    			"</div>			    		
				    		</div>
				    		<div class='float-right'>
				    			<span class='btn' style='background-color:#9AD2F7;border-radius:20px;width:50px;' data-toggle='modal' href='#openMessageModal' onclick='displayMessagesFrom(" . $input . ")'>
				    				<i class='fa fa-envelope' style='color:white;' aria-hidden='true'></i>
				    			</span>
				  			<span class='btn' style='background-color:#FF9180;border-radius:20px;width:50px;'>
				  				<a href='deleteMessage.php?messageId=$messageId&otherId=$otherId'>
				  					<i class='fa fa-trash' style='font-size:18px;color:white;' aria-hidden='true'></i>
				  				</a>
				  			</span>
				  		</div>
				  		</li>";
				}
	
				echo "<li class='list-group-item d-flex justify-content-between align-items-center light-text' style='border:0;padding-left:10px;padding-right:10px'>
				    		Send a new message
				    		<span class='btn' style='background-color:#5BB9A7;border-radius:20px;width:50px;' data-toggle='modal' href='#newMessageModal'>
				    			<i class='fa fa-paper-plane' style='font-size:16px;color:white;' aria-hidden='true'></i>
				    		</span>
				      </li>";
				echo "</ul>";
			} else {
				echo "<div class='px-2 light-text'>No messages found.</div>";
			
				echo "<li class='list-group-item d-flex justify-content-between align-items-center light-text' style='border:0;padding-left:10px;padding-right:10px'>
				    		Send a new message
				    		<span class='btn' style='background-color:#5BB9A7;border-radius:20px;width:50px;' data-toggle='modal' href='#newMessageModal'>
				    			<i class='fa fa-paper-plane' style='font-size:16px;color:white;' aria-hidden='true'></i>
				    		</span>
				      </li>";
			
				echo "</ul>";
			
			}
			
		    ?>  
    </div>
    
    
  </div>
<!-- End messages display -->

<!-- Back button -->
  <div class="row centerblock">
    <div class="col-12 col-md-auto" style="margin-bottom: 30px;">
      <a class="btn btn-primary varela small-margin-top" id="light-teal" href="main.php">Back</a>
    </div>
  </div>
</div>
  
<!-- Open Message Modal -->
  <div class="modal fade" id="openMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      
        <div class="modal-header">
          <h5 class="modal-title varela" style="font-size:18px;font-weight:600;" id="messageModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding-bottom:0px;">
        	<div class='varela light-text' id='placeMessageHere'></div>
		<hr>
	<div class='varela' style="margin-bottom:15px;">Reply</div>
	
          <form method="POST" action="addMessage.php">
		<div class="form-group">
			<input type="hidden" name="hiddenReceiverId" id="hiddenReceiverId"/>
		</div>
            <div class="form-group px-2">
              <textarea type="text" class="form-control light-text" name="newMessage" placeholder="Enter a response" rows="5" required></textarea>
            </div>
        </div>
        
        <div class="modal-footer" style=>
          <button type="button" class="btn btn-primary varela" id="light-teal" style="color:white;" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="dark-teal">Reply</button>
        </div>
        </form>
     
    </div>
  </div>
</div>

<!-- New Message Modal -->
  <div class="modal fade" id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title varela" style="font-size:18px;font-weight:600;" id="messageModalLabel">Send To</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding-bottom:0px;">

          <form method="POST" action="addMessage.php">
             <div class="form-group px-2">
              <label class="dark-text">First</label>
              <input type="text" class="form-control light-text" name="receiverFirstName" required>
            </div>
            <div class="form-group px-2">
              <label class="dark-text">Last</label>
              <input type="text" class="form-control light-text" name="receiverLastName" required>
            </div>
            <div class="form-group px-2">
              <label class="dark-text">Message</label>
              <textarea type="text" class="form-control light-text" name="newMessage" placeholder="Enter a new message" rows="5" required></textarea>
            </div>
        </div>
        <div class="modal-footer" style=>
          <button type="button" class="btn btn-primary varela" id="light-teal" style="color:white;" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary varela" style="color:white;" id="dark-teal">Send</button>
        </div>
        </form>
     
    </div>
  </div>
</div>

<script>
function displayMessagesFrom(m){
console.log(m);
    document.getElementById("messageModalLabel").innerHTML = "Message from " + m.senderFirstName;
    var message = m.message;
    var place = document.getElementById("placeMessageHere");
    place.innerHTML = message;
    
    document.getElementById("hiddenReceiverId").value = m.senderId; //switch sender to receiver for reply
    
}


</script>

</body>
</html>
