<?php
include('../loginregister/PHPMailer/PHPMailerAutoload.php');
require('./barcode.php');

    $to = 'sultana.hiramony@gmail.com';
	$subject = "Invitation Card";
    $host_name="Mr. Harsh Vardhan Shringla";
    $guest_name="Commodore M Gupta";
    $venue = "MIST, Mirpuir";
    $duration =" 5pm to 6pm";
    $dress_code = "Formal dress";
    $time_for_food = "Dinner";
    $reason = "welcome officer Traineers of the India High Commissioner";
    $phone_number = "528528504157"; // This phone number is the invitees 
      //$image = "barcode.php?text=".$phone_number;
    $data_image = barcode( "", $phone_number, "30", "horizontal", "code128", false, 1 );



			$body = "<h3>Thank you $guest_name for Joining the event. Please,
			Print the attachment & carry it with you on the event.<br>
			Regards Event Admin<h3>";
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'sultana.hiramony@gmail.com';                 // SMTP username
			$mail->Password = 'dfgdfgd';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption,
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->isHTML(true);
			$mail->setFrom('noreply@domain.com', 'EventManager');
			$mail->addAddress($to);
			$mail->Subject = $subject;
			$mail->AddEmbeddedImage('../dawatEmal/cardback.png', 'cardback');
			$mail->AddEmbeddedImage('../dawatEmal/lion.png', 'lion');
			$mail->AddEmbeddedImage($image, 'barcode_img');

      $body_content = "
      <div  style=\"background-image:url('cid:cardback');width:700px;height:600px;border:2px solid #000\">
        <div align=center>
      		<img src=\"cid:lion\" height=\"10%\" width=\"10%\">
      	</div>
      	<div align=center>
      		<h2>The High Commissioner of India,<br>$host_name</h2>
      		<h3>requests the pleasure of the company of</h3>
      		<h2>$guest_name</h2>
      		<h3>at a $time_for_food to $reason<br>
      		from the time $duration<br>
      		at $venue<br>
          Your presence is highly required.<br>
      		Dress Code: $dress_code
      		</h3>
      	</div>
      	<br><br><br><br>
      	<div>
      		<center><img src=".$image. "></center>
      		<center><h4> Email: info@gmail.com</h4></center>
      		</div>


      	</div>";

        echo $body_content;

        $mail->Body = $body_content. $body;
  			//$mail->send();
?>
<html>
<body>

  <input type="file" name="image_of_barcode" value="<?php barcode.php?text=$phone_number ?>"/>
  <?php echo $image;?>
      <br><br><img src="data:image/png;base64,"<?php file_get_contents($image);?> > <br><br>
    </body>
  </html>
