<?php 
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';
	
	if(!empty($_POST['event_name']) and !empty($_POST['event_date']) and !empty($_POST['time_from'])
        and !empty($_POST['time_to']) and !empty($_POST['event_venue']) and !empty($_POST['event_org'])){
      
      //getting all the details
	  $name = $_POST['event_name'];
	  $category = $_POST['event_category'];
	  $date = $_POST['event_date'];
      $time_from = $_POST['time_from'];
      $time_to = $_POST['time_to'];
      $venue = $_POST['event_venue'];
      $organizer = $_POST['event_org'];
      $fee = $_POST['event_fee'];
     
	  if (!empty($_FILES["image1"]["name"]))              
	  {
		$file_name=$_FILES["image1"]["name"];
		$temp_name=$_FILES["image1"]["tmp_name"];
		
		$ext= pathinfo($file_name, PATHINFO_EXTENSION);
		$target_path = "../documents/".$file_name;
				
		if(move_uploaded_file($temp_name, $target_path))
		{
			$image1=$target_path;						
		}
	  }
      
	 //data insert sql
        $sql = "INSERT into `event` (Event_name,event_category,Event_image, Event_date, Event_time_from, Event_time_to, Event_venue, Event_organizer,Event_cost,Event_expiration)
                  VALUES('$name','$category','$image1','$date','$time_from','$time_to','$venue','$organizer','$fee','No')"; 
        $res = $conn->query($sql);
        if ($res == true) {
         echo "<script type='text/javascript'>
                alert('New Event Posted Successfully!');
                window.location.href='http://localhost/Event/Event-manager/event-manager.php';
               </script>";
        }else{
           echo("Error description: " . mysqli_error($conn));
           die();
        }
      
  }
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

    <title>New Event</title>

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

        <div class="row">
	
		
			<div class="col-md-3">
                <div class="list-group">
					<a href="event-manager.php"><p class="lead list-group-item" style="background-color:powderblue;"><b> Event  </b></p></a>
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

                <div class="row carousel-holder">

					<form class="form-horizontal" action ="" method="post" enctype="multipart/form-data">
						<fieldset>
						<!-- Form Name -->
						<legend><h2>Create New Event</h2></legend>
						<br>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Event Name</label>  
							<div class="col-sm-9">
								<input oncopy="return false" onpaste="return false" name="event_name" type="text" required="" class="form-control input-md"  maxlength="20">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Event Category</label>  
							<div class="col-sm-9">
								
								<select name="event_category" >
									<option value="CULTURAL">CULTURAL</option>
									<option value="BOOK REVIEW">BOOK REVIEW</option>
									<option value="NATIONAL DAYS">NATIONAL DAYS</option>
									<option value="OFFICIAL FUNCTIONS">OFFICIAL FUNCTIONS</option>
									<option value="UN-SPECIFIED">UN-SPECIFIED</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Event Date</label>  
							<div class="col-sm-9">
								<input oncopy="return false" onpaste="return false" name="event_date" type="date" required="" class="form-control input-md"  maxlength="30">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Time From</label>  
							<div class="col-sm-9">
								<input oncopy="return false" onpaste="return false" name="time_from" type="time" required="" class="form-control input-md">
							</div>
						</div>	
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Time To</label>  
							<div class="col-sm-9">
								<input oncopy="return false" onpaste="return false" name="time_to" type="time" required="" class="form-control input-md">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Event Venue</label>  
							<div class="col-sm-9">
								<input oncopy="return false" onpaste="return false" name="event_venue" type="text" required="" class="form-control input-md"  maxlength="30">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Event Organizer</label>  
							<div class="col-sm-9">
								<input oncopy="return false" onpaste="return false" name="event_org" type="text" required="" class="form-control input-md"  maxlength="30">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Event Fee</label>  
							<div class="col-sm-9">
								<input oncopy="return false" onpaste="return false" name="event_fee" type="text" required="" class="form-control input-md"  maxlength="30">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label" for="textinput">Event Image</label>  
							<div class="col-sm-9">
								<input  name="image1" type="file" required=""  >
							</div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-offset-4 col-sm-6">
							<button type="submit" class="btn btn-primary">Publish Event</button>
						  </div>
						</div>
						</fieldset>
					</form>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2017</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

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