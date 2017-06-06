<?php 
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';
	
	//upcoming_events
	$date = date('Y-m-d');
	//echo "$date";
	$sql_upcoming_events = "SELECT * from event ORDER BY Event_date DESC";
	$res_upcoming_events = $conn->query($sql_upcoming_events);
	
	$sql_noti_count = "SELECT COUNT(Req_status) from event_request where Req_status='Pending'";
	$res_noti_count = $conn->query($sql_noti_count);
	$row_noti_count = $res_noti_count->fetch_assoc();
	
	if($res_noti_count->num_rows != 0)
	{
		$noti_count =$row_noti_count['COUNT(Req_status)'];
	}
	
?>	
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/main.css" />
    <link href="../css/shop-homepage.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../jquery/jRating.jquery.css" />
	<link rel="stylesheet" href="../assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../assets/css/mystyle.css">
	
	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	
	

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.php">Event Management</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   <li>
                        <a href="logout.php"><i class="fa fa-power-off">  Log Out</i></a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	

    <!-- Page Content -->
    <div class="container">
		<br>
		<br>

        

            <div class="col-md-3">
                <div class="list-group">
					<a href="#"><p class="lead list-group-item" style="background-color:powderblue;"><b> Event  </b></p></a>
                    <a href="create_event.php" class="list-group-item"><i class="fa fa-plus-square"> Add New Event</i></a>
					<a href="reg_list.php" class="list-group-item" <?php if($noti_count>0){ ?> style="background-color:PaleGreen;"<?php } ?> ><i class="fa fa-list-alt"> Request List (<?php echo $noti_count;?>)</i></a>
					<a href="invitation_locally.php" class="list-group-item"><i class="fa fa-print"> Print Invitation Locally</i></a>
                </div>

                <div class="list-group">
					<p class="lead list-group-item" style="background-color:powderblue;"><b> User  </b></p>
					<a href="approve_user.php" class="list-group-item"><i class="fa fa-thumbs-up"> Approve user</i></a>
					<a href="view_user.php" class="list-group-item"><i class="fa fa-eye"> View User</i></a>
					<a href="add_admin.php" class="list-group-item"><i class="fa fa-plus"> Add New Admin</i></a>
					<a href="account_settings.php" class="list-group-item"><i class="fa fa-cog"> Account Setting</i></a>
                </div>
            </div>

            <div class="col-md-9">

                 <div class="row">

                    <?php 
						$count=0;
						while($row_upcoming_events = $res_upcoming_events->fetch_assoc()){
						$count=$count+1;
						$event_name =$row_upcoming_events['Event_name'];
						$event_date =$row_upcoming_events['Event_date'];
						$event_time_from =$row_upcoming_events['Event_time_from'];
						$event_time_to =$row_upcoming_events['Event_time_to'];
						$event_venue =$row_upcoming_events['Event_venue'];
						$event_organizer =$row_upcoming_events['Event_organizer'];
						$event_cost =$row_upcoming_events['Event_cost'];
						$event_image =$row_upcoming_events['Event_image'];

					?>
						<div class="col-sm-6 col-lg-6 col-md-6">
							<div class="thumbnail">
								<img src="<?php echo $event_image ?>" alt="">
								<div class="caption">
									<h4 class="pull-right"><?php echo $event_date ?></h4>
									<h4><a href="#"><?php echo $event_name ?></a></h4>
									<h5><b>Time:</b> <?php echo $event_time_from ?> - <?php echo $event_time_to ?></h5>
										
									<h5><b>Organizer:</b> <?php echo $event_organizer ?></h5>
									<h5><b>Venue:</b> <?php echo $event_venue ?></h5>
									<p class="" style="color:green;"><b style="color:green;"> Cost:</b> <?php echo $event_cost ?></p>
									<p><a class="btn btn-warning btn-xs" target="_blank" href="#">Edit Event</a> 
									<a class="btn btn-danger btn-xs" target="_blank" href="#">Delete Event</a></p>
							
								</div>

								   
								</div>
						</div>
					<?php
						}
						if ($count==0)
						{
					?>
						<p>No upcoming events</p>
					<?php
						}
					?>
                </div>

            </div>

      

    </div>
    <!-- /.container -->

        <hr>

        <!-- Footer -->
<section id="four" class="wrapper style2 special">
		<div class="inner" id="go_contact">
		
			<ul class="icons">
				<li><a href="#" class="icon fa-facebook">
					<span class="label">Facebook</span>
					</a></li>
				<li><a href="#" class="icon fa-twitter">
						<span class="label">Twitter</span>
					</a></li>
				<li><a href="#" class="icon fa-instagram">
						<span class="label">Instagram</span>
					</a></li>
				<li><a href="#" class="icon fa-linkedin">
						<span class="label">LinkedIn</span>
					</a></li>
			</ul>
			<ul class="copyright">
				<li> Copyright &copy;  2017</li>
			</ul>
			
		</div>
	</section>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/skel.min.js"></script>
	<script src="../assets/js/util.js"></script>
	<script src="../assets/js/main.js"></script>
	<script src="../jquery/jquery.js"></script>
	<script src="../jquery/jRating.jquery.js"></script>
	

</body>

</html>
<?php
}
?>