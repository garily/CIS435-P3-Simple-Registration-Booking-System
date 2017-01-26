<!DOCTYPE html>

<!--CIS 435 Project 3
    By Ruoyu Li-->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/main.css">
    <title>Project 3 - Demo Registration</title>
    <?php   	
 		$host = 'cis435-proj-3.cr5h78hg8xtz.ap-northeast-1.rds.amazonaws.com';
		$username = 'admin';
		$password = 'cis435';
		$db = 'CIS435_Proj3_DB';
		$conn = mysqli_connect($host, $username, $password);
		$status = mysqli_select_db($conn, $db);
   		if(! $conn ) {
   			die('Could not connect: ' . mysqli_connect_error());
	    }
	    $seatQuery = 'SELECT * FROM TimeSlot';
		$seats = mysqli_query($conn, $seatQuery);
		$slots = array('12/9/15, 6:00 PM – 7:00 PM,', '12/9/15, 7:00 PM – 8:00 PM,', '12/9/15, 8:00 PM – 9:00 PM,',
			'12/9/16, 6:00 PM – 7:00 PM,', '12/9/16, 7:00 PM – 8:00 PM,', '12/9/16, 8:00 PM – 9:00 PM,');
	?>
</head>
<body>
	<h1 class="center">Demonstration Time Slot Registratioin</h1>
	<br/>
	<div id="formInput">
    <form action="scripts/inquiry.php" method="post">
    <table>
        <tr>
            <td class="left"><label for="firstName">First Name:</label></td>
            <td><input type="text" id="firstName" name="firstName" placeholder="* First Name (Letters Only)" maxlength="45"
            	pattern="[a-zA-Z]{1,45}" required/></td>
        </tr>
        <tr>
            <td class="left"><label for="lastName">Last Name:</label></td>
            <td><input type="text" id="lastName" name="lastName" placeholder="* Last Name (Letters Only)" maxlength="45"
            	pattern="[a-zA-Z]{1,45}" required/></td>
        </tr>
        <tr>
            <td class="left"><label for="UMID">UMID:</label></td>
            <td><input type="text" id="UMID" name="UMID" placeholder="* 8-Digit UMID"
            	pattern="\d{8}" maxlength="8" required/></td>
        </tr>
        <tr>
            <td class="left"><label for="projTitle">Project Title:</label></td>
            <td><input type="text" id="projTitle" name="projTitle" placeholder="* Project Title" maxlength="45"
            	required/></td>
        </tr>
        <tr>
            <td class="left"><label for="emailAddr">Email Address:</label></td>
            <td><input type="email" id="emailAddr" name="emailAddr" placeholder="* someone@example.com"
            	maxlength="80" required/></td>
        </tr>
        <tr>
            <td class="left"><label for="phoneNumber"> Phone Number:</label></td>
            <td><input type="text" id="phoneNumber" name="phoneNumber" placeholder="* XXX-XXX-XXXX"
            	pattern="^\d{3}-\d{3}-\d{4}$" maxlength="12" required/></td>
        </tr>
        <tr>
            <td class="left">Time Slot</td>
            <td>
                <select name="regInfo" required>
                	<option value="">* Please Select</option>
					<?php
						for ( $i = 0; $row = mysqli_fetch_row($seats); $i++) {
							if($row[1] == 0 )
								print( "<option value = ".($i+1)." disabled>$slots[$i]<br/>$row[1] seats remaining</option>" );
							else
    							print( "<option value = ".($i+1).">$slots[$i]<br/>$row[1] seats remaining</option>" );
						}
					?>
                </select>
            </td>
        </tr>
    </table>
    <br/>
    <input class="btn" type="submit" name="submit" value="Submit"/>
    </form>
    <br/>
    <div >
    <input class="btn" type="button" value="View Registration List" onclick="location.href='scripts/list.php';"/>
	</div>
    
</div>

</body>
</html>

