<?php
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';
	//include('../loginregister/PHPMailer/PHPMailerAutoload.php');

	$id = $_GET['accept_id'];

	$sql = "UPDATE members set active = 'Yes' where memberID = $id";



	$res = $conn->query($sql);

	if ($res == TRUE) {
		echo "<script type = 'text/javascript'>
				 	alert('User Approved!');
				 	window.location = 'approve_user.php';
			  </script>";
	}else{
		echo "Error: " . $sql . "<br>" . $conn->error;;
	}
}
?>
