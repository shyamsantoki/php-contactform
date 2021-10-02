<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

if(!empty($_POST['g-recaptcha-response'])) {
	$secret = 'recaptcha-private-key';
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	$responseData = json_decode($verifyResponse);
	if ($responseData->success) {
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$message = $_POST['message'];
		require 'class/class.phpmailer.php';
		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->Host = 'smtp-hostname';
		$mail->Port = 'smtp-port';
		$mail->SMTPAuth = true;
		$mail->SMTPDebug = false;
		$mail->Username = 'smtp-username';
		$mail->Password = 'smtp-password';
		$mail->SMTPSecure = '';
		$mail->From = 'sender-email';
		$mail->FromName = 'sender-name';
		$mail->AddAddress('receiver-address');
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = 'Contact form submission';
		$message_body = "
			<p><b>Firstname:</b> $name</p>
			<p><b>Lastname:</b> $surname</p>
			<p><b>Email:</b> $email</p>
			<p><b>Phone number:</b> $phone</p>
			<p><b>Message:</b> $message</p>
		";
		$mail->Body = $message_body;
		$mail->Send();
	}
}

?>