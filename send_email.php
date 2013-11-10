<?php
	$isgd = $_GET["url"];
	$excerpt = $_GET["excerpt"];
	$title = $_GET["title"];
	$to = $_GET["emailTo"];
	$sender = $_GET["nameFrom"];
	$sender_email = $_GET["emailFrom"];
	$cc = $_GET["cc"] == "true";

	$subject = $title;

	$headers = "To: $to\r\n";
	$headers .= "From: $sender <$sender_email>\r\n";
	if($cc){
		$headers .= "Cc: $sender_email\r\n";
	}
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$message = "<html><body style='font-family:sans-serif;width:75%;margin:auto;'><h1 align='center'><img src='http://tji.eu5.org/img/logo.jpg' width='130' alt='This Just In'></h1><h2 align='center'>$title</h2><p>$excerpt</p><p><a href='$isgd'>Continue reading &rarr;</a></p><hr><p align='center'>Sent by $sender through <a href='http://tji.eu5.org'>This Just In</a><p></body></html>";
	
	mail($to, $subject, $message, $headers);