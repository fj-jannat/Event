<?php
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';
	$error = "";

	$sql_noti_count = "SELECT COUNT(Req_status) from event_request where Req_status='Pending'";
	$res_noti_count = $conn->query($sql_noti_count);
	$row_noti_count = $res_noti_count->fetch_assoc();

	if($res_noti_count->num_rows != 0)
	{
		$noti_count =$row_noti_count['COUNT(Req_status)'];
	}
	
	$manager_ID = $_SESSION['sess_user'];
	
	$sql_account_info = "SELECT * FROM `login` WHERE Manager_id ='$manager_ID'";
	$res_account_info = $conn->query($sql_account_info);
	
	//save changes made
	if(isset($_POST['change'])){
		
		if(md5($_POST['cur_pass']) == $_POST['pass']){	
			
			if( $_POST['new_pass']!= ""  && $_POST['new_pass'] == $_POST['conf_pass']){
				
				$hashedpassword = md5($_POST['new_pass']);				
				$update_login_info = "UPDATE login SET `password`='$hashedpassword' WHERE `Manager_id` = '$manager_ID'";
				$res_login_info = $conn->query($update_login_info);
				
			}else{
				$error .="Passwords do not match<br>";
			}	
			
		}else{
			$error .="Password Incorrect<br>";
		}	
	}


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
	<link rel="shortcut icon" href="../image/favicon.ico" type="image/vnd.microsoft.icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<!-- Bootstrap Core CSS -->
	<link href="../css/bootstrap.css" rel="stylesheet">
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

    <style>
  * {font-family: Helvetica Neue, Arial, sans-serif; }


    h1, table { text-align: center; }

    table {border-collapse: collapse;  width: 85%; margin: 0 auto 5rem;}

    th, td { padding: 1.5rem; font-size: 1.3rem; text-align: center;}

    tr {background: hsl(50, 50%, 80%); }

    tr, td { transition: .4s ease-in; }

    #firstrow {background: hsla(12, 50%, 20%, 0.5); font-weight: 1000;}

    tr:nth-child(even) { background: hsla(50, 100%, 30%, 0.7); }

    td:empty {background: hsla(50, 25%, 60%, 0.7); }


   </style>

  <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });


  </script>

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

                <div id="page-wrapper">
				<legend>Account settings</legend>

				<div class="col-md-9">
			<div class="row carousel-holder">

                <div class="row">
					<?php
					if($row_account_info = $res_account_info->fetch_assoc()){
					
						$email =$row_account_info['email'];
						$pass =$row_account_info['password'];				
						
						
					}

					?>
				<p class="bg-danger"><b><?php echo $error;?></b></p><br>
					<form action="" method="post" enctype="multipart/form-data" >
					
						<div class="form-group col-md-3"><br>
							<b>Email Address </b>
						</div>
						<div class="form-group col-md-9">
							 <input type="text" name="email" value="<?php echo $email;?>"  disabled>
						</div>
						
						<br>
				
						

						<Legend><br>Change Password</Legend>

						<div class="form-group col-md-3">
							<b>Current Password<font color="red">*</font></b>
						</div>	
						<div class="form-group col-md-9">
							 <input type="password" name="cur_pass" required="" class="form-control input-md"/>
						</div><br>
						<div class="form-group col-md-3"><br>
							<b>New Password</b>
						</div>	
						<div class="form-group col-md-9">
							 <input type="password" name="new_pass" placeholder="********"  >
						</div><br>
						<div class="form-group col-md-3">
							<b>Confirm Password </b>
						</div>
						<div class="form-group col-md-9">
							 <input type="password" name="conf_pass" placeholder="********"  >
						</div>
						<input hidden name="pass" value="<?php echo $pass;?>">

						<div class="form-group col-md-9">
						<center> <button name="change" class="btn btn-info"    > Save Changes</button></center>
						</div>
					</form>

                </div>

            </div>

        </div>



</div>

			  </div><!-- /#page-wrapper -->

            </div>

        </div>

    </div>

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                
            </div>
        </footer>

    </div>



    <!-- JavaScript -->
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="../js/call.js">  </script>
  </body>
</html>
<?php
}
?>
