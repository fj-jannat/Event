<?php
include('PHPMailer/PHPMailerAutoload.php');
$first_name="zemy";
$to = 'sultana.hiramony@gmail.com';
			echo '<h1> $to </h1>';
			$subject = "Invitation Card";
			$body = "Thank you for JOnng the event. prnt the attachment Regards Event Admin";
			$mail = new PHPMailer;                                         // Set mailer to use SMTP
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'sultana.hiramony@gmail.com';                 // SMTP username
			$mail->Password = 'hdghghgjshk';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to
			$mail->isHTML(true);
			$mail->setFrom('sultana.hiramony@gmail.com', 'EventManager');
			$mail->addAddress($to);
			$mail->Subject = $subject;
		  $mail->Body = "<div style='margin-left:150px;background-image:url(http://archive.customize.org/files/old/wallpaper/files/Surreal_Red_big.jpg); padding:50px;width:600px;'>
<h1 style='color:#FFFFFF;font-family: Arial, Helvetica, sans-serif;text-align:center;line-height:2.5em;'>Diwali Wishes!</h1>
<hr>
<table>
<tr><td style='text-align:center'>
<div>
<a href=''><img src='http://webneel.com/daily/sites/default/files/images/daily/09-2013/14-diwali-greeting-card.jpg' align='left' style='width:250px;height:250px;' alt=''/></a>
<p style='color:#FFFFDD; font-family: Allura,cursive,Arial, Helvetica, sans-serif; font-size:20px'>'Have a prosperous Diwali.Hope this festival of lights,brings you every joy and happiness.May the lamps of joy,illuminate your life and fill your days with the bright sparkles of peace,mirth and good will.'</p>
</div>
</td>
</tr>
<tr>
<td><div style='float:left;'><p style='color:#FFFFFF;font-family: Arial, Helvetica, sans-serif; font-size:20px'>'May the joy, cheer, Mirth and merriment Of this divine festival Surround you forever......'</p></div></td>
</tr>
</table>
</div>";
// $mail->ContentType = 'multipart/alternative';
			$mail->send();

?>
