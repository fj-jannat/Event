<?php

	$memberID = $_SESSION["memberID"];
	require '../func/connect.php';

	$id = $_GET['event_id'];
	$date = date('Y-m-d');
	$sql = "INSERT INTO `event_request` (Event_id,Cust_id,Req_date, Req_status)
                  VALUES('$id','$memberID','$date','Pending')"; 
				  

	$res = $conn->query($sql);

	if ($res == TRUE) {
		echo "<script type = 'text/javascript'>
				 	alert('Join Request Sent!');
				 	window.location = 'memberpage.php';
			  </script>";
	}else{
		echo "Error: " . $sql . "<br>" . $conn->error;;
	}

?>
