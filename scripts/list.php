<!DOCTYPE html>
<!--CIS 435 Project 3
    By Ruoyu Li-->

<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/main.css">
    <title>Project 3 - Registration List</title>
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
	    $listQuery = 'SELECT * FROM StudentInfo';
		$nameList = mysqli_query($conn, $listQuery);
		
		$slots = array('12/9/15,<br/>6:00 PM – 7:00 PM', '12/9/15,<br/>7:00 PM – 8:00 PM', '12/9/15,<br/>8:00 PM – 9:00 PM',
			'12/9/16,<br/>6:00 PM – 7:00 PM', '12/9/16,<br/>7:00 PM – 8:00 PM', '12/9/16,<br/>8:00 PM – 9:00 PM');
	?>
</head>

<body>
	<h1 class="center">Demonstration Time Slot Registration Information</h1>
	<br/>
	<table id="listTable" class="center">
		<tr>
			<th id="umid">UMID</th>
			<th id="name">Name (FL)</th>
			<th id="projtitle">Project Title</th>
			<th id="emailaddr">Email Address</th>
			<th id="phonenumber">Phone Nmber</th>
			<th id="reginfo">Time Slot Registered</th>
		</tr>
		<?php		
		for ( $i = 0; $row = mysqli_fetch_row($nameList) ; $i++) {
			print("<tr>");
			print("<td id='umid'>$row[0]</td>");
			print("<td id='name'>$row[1] $row[2]</td>");
			print("<td id='projtitle'>$row[3]</td>");
			print("<td id='emailaddr'>$row[4]</td>");
			print("<td id='phonenumber'>$row[5]</td>");
			switch ($row[6]) {
				case 1:
					print("<td id='reginfo'>$slots[0]</td>");
					break;
				case 2:
					print("<td id='reginfo'>$slots[1]</td>");
					break;
				case 3:
					print("<td id='reginfo'>$slots[2]</td>");
					break;
				case 4:
					print("<td id='reginfo'>$slots[3]</td>");
					break;
				case 5:
					print("<td id='reginfo'>$slots[4]</td>");
					break;
				case 6:
					print("<td id='reginfo'>$slots[5]</td>");
					break;
				Default:
					print("<td id='reginfo'>$row[6]</td>");
			}
			print("</tr>");
		}
		?>
	</table>
	<br/>
	<div class="center">
		<input type="button" class="btn" onclick="location.href='../index.php';" value="Back" class="center"/>
	</div>
	
</body>
</html>


<?php
?>