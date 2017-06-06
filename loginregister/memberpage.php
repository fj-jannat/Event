<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Members Page';

//include header template
$locationLink = './logout.php';
$loginstate = 'fa fa-power-off';
$state = "Log Out";
require('../include/front.php');

	require '../func/connect.php';

	//upcoming_events
	$date = date('Y-m-d');
	$memberId=  $_SESSION['memberID'];
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

	
	//event_list
	$sql_upcoming_events = "SELECT * from event where Event_date >= $date ORDER BY Event_date DESC";
	$res_upcoming_events = $conn->query($sql_upcoming_events);
	
	
	//event req sent
	if(isset($_POST['joining_btn'])){
		$id=$_GET['event_id'];
		$date = date('Y-m-d');
		$sql = "INSERT INTO `event_request` (Event_id,Cust_id,Req_date, Req_status)
					  VALUES('$id','$memberId','$date','Pending')"; 
					  

		$res = $conn->query($sql);

		
	}
?>
<br><br>
<div class="container">
	<div class="row">
				<div class="col-md-3">
					<div class="list-group">
							<p class= "lead list-group-item" style="background-color:powderblue;">Welcome <?php echo $_SESSION['username']; ?></p>
					</div>


						<div class="list-group">
			<p class="lead list-group-item" style="background-color:powderblue;"><b> Event  </b></p>
								<a href="memberpage.php" class="list-group-item"><i class="fa fa-list-alt"> Event List</i></a>
						</div>

						<div class="list-group">
			<p class="lead list-group-item" style="background-color:powderblue;"><b> User  </b></p>
			<a href="member_acc_setting.php" class="list-group-item"><i class="fa fa-cog"> Account Setting</i></a>
						</div>
				</div>

		<div class="col-md-9">
			<div class="row carousel-holder">

                <div class="row">
				
					<?php 
						$count=0;
						while($row_upcoming_events = $res_upcoming_events->fetch_assoc()){
						$count=$count+1;
						$event_name =$row_upcoming_events['Event_name'];
						$event_id =$row_upcoming_events['Event_id'];
						$event_category =$row_upcoming_events['event_category'];
						$event_date =$row_upcoming_events['Event_date'];
						$event_time_from =$row_upcoming_events['Event_time_from'];
						$event_time_to =$row_upcoming_events['Event_time_to'];
						$event_venue =$row_upcoming_events['Event_venue'];
						$event_organizer =$row_upcoming_events['Event_organizer'];
						$event_cost =$row_upcoming_events['Event_cost'];
						$event_image =$row_upcoming_events['Event_image'];
						
						//event_status_fetchin_sql
						
						$sql_status_fetch = "SELECT Req_status from event NATURAL Join event_request where Cust_id='$memberId' and event_request.Event_id='$event_id'";
						$res_status_fetch = $conn->query($sql_status_fetch);
						$row_status = $res_status_fetch->fetch_assoc();
						if($res_status_fetch->num_rows == 1)
						{	
							$event_status=$row_status['Req_status'];
							
						}
						else
						{
							$event_status="";
						}
						////////
						if($event_status=="Pending")
						{
							$button_name="Request Sent!";
							$button_color="warning";
							$button_href="";
							$button_status="disabled";
						}
						else if($event_status=="Accepted")
						{
							$button_name="Already Joined!";
							$button_color="success";
							$button_href="";
							$button_status="disabled";
						}
						else
						{
							$button_name="Join Now!";
							$button_color="info";
							$button_href="memberpage.php";
							$button_status="";
						}
						
						//
						$_SESSION['memberID']= $memberId;
						

					?>
						<div class="col-sm-6 col-lg-6 col-md-6">
							<div class="thumbnail">
								<a href="loginregister/login.php"><img src="<?php echo $event_image ?>" alt=""></a>
								<div class="caption">
									<h4 class="pull-right" style="color:blue;"><?php echo $event_date; ?></h4>
									<h4 style="color:blue;"><?php echo $event_name ?></h4>
									
										<style>
										 dummydeclaration {padding-left: 4em;}
										 tab  { padding-left: 4em;}
										 tab1 { padding-left: 6em;}
										 tab2 { padding-left: 3em;}

										</style>
										<strong>Category</strong>&nbsp;&nbsp;
										<tab><?php echo $event_category ?>
										
										<br>
										<strong>Time</strong>&nbsp;&nbsp;
										<tab1><?php echo $event_time_from ." - ". $event_time_to ?>
	
										<br>
										<strong>Organizer</strong>
										<tab><?php echo $event_organizer ?>			
										
										<br>
										<strong>Venue</strong>&emsp;&emsp;&nbsp;&nbsp;&nbsp;
										<tab2><?php echo $event_venue ?>
										
										<br>
										<strong>Dress Code</strong>
										<tab2>DRESS
										
										<br>
										<strong><font color= "green">Cost</font></strong>&nbsp;&nbsp;
										<tab1><font color= "green"><?php echo $event_cost ?></font>
										<br>
										<br>
										<form method="post" action="<?php echo $button_href; ?>?event_id=<?php echo $event_id; ?>" >								
										<center> <button name="joining_btn" class="btn btn-<?php echo $button_color; ?> btn-sm"  onclick ="return confirm('Sure to Join?'); " <?php echo $button_status; ?> ><?php echo $button_name;?></button></center>
										</form>
									
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



</div>

<?php
//include header template
require('../include/footer.php');
?>
