<?php
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';
	//include('../loginregister/PHPMailer/PHPMailerAutoload.php');

	$id = $_GET['accept_id'];

	$sql = "UPDATE event_request set Req_status = 'Accepted' where Serial = $id";



	$res = $conn->query($sql);

	if ($res == TRUE) {
		echo "<script type = 'text/javascript'>
				 	alert('Registration Accepted!');
				 	window.location = 'reg_list.php';
			  </script>";
	}else{
		echo "Error: " . $sql . "<br>" . $conn->error;;
	}
}
?>
