<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/main.css">
    <title>Submission Result</title>
    
</head>
<body>
	<div id ="php" class="center">
	<?php
    	$host = 'cis435-proj-3.cr5h78hg8xtz.ap-northeast-1.rds.amazonaws.com';
    	$username = 'admin';
    	$password = 'cis435';
    	$db = 'CIS435_Proj3_DB';
    	$conn = mysqli_connect($host, $username, $password);
		$ifDup = false;
		$timeSlots = array('12/9/15, 6:00 PM – 7:00 PM', '12/9/15, 7:00 PM – 8:00 PM', '12/9/15, 8:00 PM – 9:00 PM',
			'12/9/16, 6:00 PM – 7:00 PM', '12/9/16, 7:00 PM – 8:00 PM', '12/9/16, 8:00 PM – 9:00 PM');
		
	
	    $status = mysqli_select_db($conn, $db);
	
	    //try connecting to DB
    	if(! $conn ) {
	        die('Could not connect: ' . mysqli_connect_error());
	    }
	
	
    	if (isset($_POST['UMID'])) { $UMID = $_POST['UMID'];}
    	if (isset($_POST['firstName'])) { $firstName = $_POST['firstName'];}
    	if (isset($_POST['lastName'])) { $lastName = $_POST['lastName'];}
    	if (isset($_POST['projTitle'])) { $projTitle = $_POST['projTitle'];}
    	if (isset($_POST['emailAddr'])) { $emailAddr = $_POST['emailAddr'];}
    	if (isset($_POST['phoneNumber'])) { $phoneNumber = $_POST['phoneNumber'];}
    	if (isset($_POST['regInfo'])) { $regInfo = $_POST['regInfo'];}
	
	    $sql = "INSERT INTO StudentInfo
        	(UMID, firstName, lastName, projTitle, emailAddr, phoneNumber, regInfo)
        	VALUES ('$UMID', '$firstName', '$lastName', '$projTitle', '$emailAddr', '$phoneNumber', '$regInfo');";
	
	    $result = mysqli_query($conn, $sql);
		if($result) {
			$sql = "UPDATE TimeSlot SET `remainSeats` = IF(`remainSeats` > 0, `remainSeats` - 1, 0) WHERE `slotNumber`='$regInfo';";
			$result = mysqli_query($conn, $sql);
			if($result) {
        		echo '<br/>Submission Successful';
				$msg =  mysqli_error($conn);
				$tmp = $regInfo - 1;
				print ("<br/>Thank you, you are now registered for demonstration on<br/>$timeSlots[$tmp]!" );
			}
			else {
				echo $msg = mysqli_error($conn);
			}
		}
    	else {
    		$msg =  mysqli_error($conn);	        
			if (substr($msg,0,9) == "Duplicate") {
				$ifDup = true;
			}
			else {
				echo $msg =  mysqli_error($conn);
			}	
	    }
	?>
	
	<script type="text/javascript">
	var r = false;
	var tmp = <?php echo $ifDup?>;
	if (tmp) r = confirm("You have already registered, do you wish to update your registration,in which case the previous time slot\n will be cancelled and transferred to the one you just selected?");
	if(r) document.writeln("<?php	
		if ($ifDup) {
			$sql = "UPDATE TimeSlot SET `remainSeats` = IF(`remainSeats`> 0, `remainSeats` - 1, 0) WHERE `slotNumber`=$regInfo;";
			$result = mysqli_query($conn, $sql);
			if($result) {
				$sql = "SELECT `regInfo` FROM StudentInfo WHERE `UMID`=$UMID;";
				$result = mysqli_query($conn, $sql);
				if($result) {
					$reg = mysqli_fetch_row($result);
					$sql = "UPDATE TimeSlot SET `remainSeats` = IF(`remainSeats` < 6, `remainSeats` + 1, 6) WHERE `slotNumber`=$reg[0];";
					$result = mysqli_query($conn, $sql);
					if($result) {
						$sql = "UPDATE StudentInfo SET `firstName`='$firstName', `lastName`='$lastName', `projTitle`='$projTitle', `emailAddr`='$emailAddr', `phoneNumber`='$phoneNumber', `regInfo`='$regInfo' WHERE `UMID`='$UMID';";
						$result = mysqli_query($conn, $sql);
						if($result) {
							echo '<br/>Submission Successful';
							$tmp = $reg[0] - 1;
							print ("<br/>Thank you, you are now registered for demonstration on<br/>$timeSlots[$tmp]!" );
						}
						else {
							echo '<br/>Error updating database: '.mysqli_error($conn);
						}
					}
					else {
						echo '<br/>Error updating database: '.mysqli_error($conn);
					}
				}
				else {
			       echo '<br/>Error updating database: '.mysqli_error($conn);
	 	   		}
    		}
    		else {
			       echo '<br/>Error updating database: '.mysqli_error($conn);
	 	   }
			
		}
	?>" );
		
	</script>
	</div>
	<div class="center">
	<br/>
	<input type="button" onclick="location.href='../index.php';" value="Back" class="center"/>
	</div>
</body>
</html>
