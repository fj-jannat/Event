<?php
	include_once( 'class.ManageRatings.php' );
	$init = new ManageRatings;
	$allHotItems = $init->getHotItems();
?>