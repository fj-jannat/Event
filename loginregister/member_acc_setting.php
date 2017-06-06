<?php require('includes/config.php');
$error="";
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

	
	//save changes made
	if(isset($_POST['change'])){
		
		$phone = $_POST['phone'];
		
		
		if($_POST['phone']=="")
				$error .="Phone number cannot be empty<br>";
		
		
		if($user->password_verify($_POST['cur_pass'],$_POST['pass'])){	
			if( $_POST['new_pass'] ==""  && $phone !=""){
			
				$update_member_info = "UPDATE members SET `phone` = '$phone' WHERE `memberID` = '$memberId'";
				$res_member_info = $conn->query($update_member_info);
				
			}
			if( $_POST['new_pass']!= ""  && $_POST['new_pass'] == $_POST['conf_pass']  &&  $phone !=""){
				
				$hashedpassword = $user->password_hash($_POST['new_pass'], PASSWORD_BCRYPT);
				//echo "dhuksi";
				
				$update_member_info = "UPDATE members SET `phone` = '$phone', `password`='$hashedpassword' WHERE `memberID` = '$memberId'";
				$res_member_info = $conn->query($update_member_info);
				
			}else{
			$error .="Passwords do not match<br>";
		}	
			
		}else{
			$error .="Password Incorrect<br>";
		}	
	}
	
	$sql_account_info = "SELECT * FROM `members` WHERE memberID='$memberId'";
	$res_account_info = $conn->query($sql_account_info);
	
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
					if($row_account_info = $res_account_info->fetch_assoc()){
						$name =$row_account_info['username'];
						$phone =$row_account_info['phone'];
						$email =$row_account_info['email'];
						$pass =$row_account_info['password'];
						$image =$row_account_info['image'];
						
						//header('Content-type: image/png');
						//echo $image;
						
						
					}

					?>
					
				<Legend>Edit Account Information</Legend>
				<p class="bg-danger"><b><?php echo $error;?></b></p><br>
					<form action="" method="post" enctype="multipart/form-data" >
					
						<div class="form-group col-md-3"><br>
							<b>Email Address </b>
						</div>
						<div class="form-group col-md-9">
							 <input type="text" name="email" value="<?php echo $email;?>"  disabled>
						</div>
						
						<br>
				
						<div class="form-group col-md-3"><br>
							<b>Phone No </b>
						</div>	
						<div class="form-group col-md-9">
							 <input type="text" name="phone" value="<?php echo $phone;?>"  >
						</div><br>

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

<?php
//include header template
require('../include/footer.php');
?>
