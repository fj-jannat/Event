<?php
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';

	$id = $_GET['reject_id'];

	$sql = "DELETE FROM `members` where memberID = $id";



	$res = $conn->query($sql);

	if ($res == TRUE) {
		echo "<script type = 'text/javascript'>
				 	alert('User Deleted!');
				 	window.location = 'view_user.php';
			  </script>";
	}else{
		echo "Error: " . $sql . "<br>" . $conn->error;;
	}
}
?>
