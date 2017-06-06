<?php

	$response['success'] = false;
	$response['error'] = false;

	include_once( 'ip.php' );
	include_once( 'class.ManageRatings.php' );
	$init = new ManageRatings; // creating the object 

	//getting the values for new rate
	if($_POST)
	{
		$id = $_POST['idBox'];
		$rate = $_POST['rate'];
	}
	
	$ip_address = GetUserIP(); // getting the user ip address
	$existingData = $init->getItems($id); // get the data by id
	
	foreach($existingData as $data)
	{
		$old_total_rating = $data['total_rating']; // get the old total rating 
		$total_rates = $data['total_rates']; // get the old number of people who rated
	}

	$current_rating = $old_total_rating + $rate; 
	$new_total_rates = $total_rates + 1;
	$new_rating = $current_rating / $new_total_rates; //new avg
	
	$insert = $init->insertRatings($id,$new_rating,$current_rating,$new_total_rates,$ip_address); //update the value
	
	if($insert == 1)
	{
		$response['success'] = 'Success';
	}
	else
	{
		$response['error'] = 'Error';
	}
	echo json_encode($response);
?>