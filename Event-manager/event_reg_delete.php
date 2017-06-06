<?php 
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';
	
	$id = $_GET['delete_id'];

	$sql = "DELETE from event_request where Serial = $id";

	$res = $conn->query($sql);
	
	if ($res == TRUE) {
		echo "<script type = 'text/javascript'>
				 	alert('Deleted successfully');
				 	window.location = 'reg_list.php';
			  </script>";
	}else{
		echo "Error: " . $sql . "<br>" . $conn->error;;
	}
}
?>