<?php
require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}

	//Phone validation
	if(!$_POST['phone']){
	    $error[] = 'Please enter a Contact Number';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE phone = :phone');
		$stmt->execute(array(':phone' => $_POST['phone']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['phone'])){
			$error[] = 'Contact number provided is already in use.';
		}

	}

	//image prepare for upload

	if($_FILES['image']['name']==""){
		$error[] = 'Please choose your Image';
	}else{

		if(getimagesize($_FILES['image']['tmp_name'])==FALSE){
			$error[] = 'Please choose your Image';
		}else{
			/* if(getimagesize($_FILES['image']['tmp_name'])> 64000){
			$error[] = 'Image size must be less than 64kB';
			}else{ */
				$image = addslashes($_FILES['image']['tmp_name']);
				$image = file_get_contents($image);
				$image = base64_encode($image);
			//}
		}

	}


	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (username,password,email,active,phone,image) VALUES (:username, :password, :email, :active, :phone,:image)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email'],
				':phone' => $_POST['phone'],
				':image' => $image,
				':active' => $activasion
			));
			$id = $db->lastInsertId('memberID');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "Thank you for registering at Event Management website.<br>
			To activate your account, please click on this link:'".DIR."activate.php?x=$id&y=$activasion'
			Regards Event Admin";
			$mail = new PHPMailer;                                         // Set mailer to use SMTP
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = H_MAIL;                 // SMTP username
			$mail->Password = H_PASS;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->setFrom(SITEEMAIL, 'EventManager');
			$mail->addAddress($to);
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->AddEmbeddedImage('img/backreset.jpg', 'backreset');
			$mail->Body = "<div style='margin-left:100px;background-image:url(\"cid:backreset\"); padding:50px;width:400px;height:500px;'>
				<h1 style='color:#00000;font-family: Arial, Helvetica, sans-serif;text-align:center;line-height:2.5em;'>
				Registration Confirmation</h1>
	<table>
		<tr>
			<td style='text-align:center'>
				<div>
				<p style='color:#000000; font-family: Allura,cursive,Arial, Helvetica, sans-serif; font-size:20px'>
				Dear valued Customer,<br>
				Thank you for registering at Event Management website.<br>
				Please click <a href=\"".DIR."activate.php?x=$id&y=$activasion\">
				here</a> to activate your account,
				<h5>With best regards Event Admin<h5>
				</div>
			</td>
		</tr>
	</table>
</div>";
			$mail->send();
			//redirect to index page zeny
			header('Location: success.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'User Registration';
$locationLink = './login.php';
$loginstate = 'fa fa-user';
$state = "User Login";
//include header template
require('../include/front.php');
?>
<br>
<br>
<br>
<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="index.php" enctype="multipart/form-data" autocomplete="off">
				<h2>Please Sign Up</h2>
				<p>Already a member? <a href='login.php'>Login</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess zeny
				//if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					//echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
				//}
				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" required value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="phone" name="phone" id="phone" class="form-control input-lg" placeholder="Contact Number. Ex: 01XXXXXXXXX" pattern="[0-9]{11}" required value="<?php if(isset($error)){ echo $_POST['phone']; } ?>" tabindex="6">
				</div>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" required value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
				</div>
				<div class="row">
					<div class="col-xs-3 col-sm-3 col-md-3">
						<div class="form-group">
							<label><h5>Insert Profile Image</h5></label>
						</div>
					</div>
					<div class="col-xs-9 col-sm-9 col-md-9">
						<div class="form-group">
							<input type="file" name="image" id="image" class="form-control input-lg" required placeholder="Choose Your Image" value="" tabindex="7">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" required placeholder="Password" tabindex="3">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" required placeholder="Confirm Password" tabindex="4">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>
	</div>

</div>

<?php
//include header template
//require('layout/footer.php');
require ('../include/front.php');
?>
