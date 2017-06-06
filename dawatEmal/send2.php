<?php
include('PHPMailer/PHPMailerAutoload.php');
$first_name="zeny";
$to = 'sultana.hiramony@gmail.com';
			//echo '<h1> $to </h1>';
			$subject = "Invitation Card";
			$body = "<h3>Thank you for Joining the event. Please,
			Print the attachment & carry it with you on the event.<br>
			Regards Event Admin<h3>";
			$mail = new PHPMailer;                                         // Set mailer to use SMTP
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'sultana.hiramony@gmail.com';                 // SMTP username
			$mail->Password = 'gfsjdh';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->isHTML(true);
			$mail->setFrom('sultana.hiramony@gmail.com', 'EventManager');
			$mail->addAddress($to);
			$mail->Subject = $subject;
		  $mail->Body = "<div  style='background-image: url('cardback.jpg');width:700px;height:500px;border:2px solid #000'>

	<div align=center>
		<img src='lion.png' height='10%' width='10%'>
	</div>
	<div align=center>
		<p style='font-family: Allura,cursive,Arial, Helvetica, sans-serif; font-size:20px'>
		<h2>The High Commissioner of India,<br>
		Mr. Harsh Vardhan Shringla</h2>
		<h3>requests the pleasure of the company of</h3>
		<h2>Commodore M Gupta</h2>
		<h3>at a dinner to welcome officer Traineers of the<br>
		for whom???? <br>
		day date time <br>
		Vanue
		</h3></p>
		</div>

		<div>
		<h4>Email: sultana.hiramony@gmail.com</h4>
		<img src='barcode.php?text=sultana.hiramony@gmail.com'>
		</div>


	</div>". $body;
// $mail->ContentType = 'multipart/alternative';
			$mail->send();

?>
