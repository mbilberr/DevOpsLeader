<?php
require_once "/usr/share/php/libphp-phpmailer/class.phpmailer.php";

include('index.html');
include('db_info.php');


$lastID = $dbname->lastInsertId();

$message = '<html><head>
	   <title>Email Verification</title>
	   </head>
	   <body>';
$message .= '<h1>Hi ' . $username . '!</h1>';
$message .= '<p><a href="'.$servername.'activate.php?id=' . base64_encode($lastID) . '">CLICK TO ACTIVATE YOUR ACCOUNT</a>';
$message .= "</body></html>";

$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;

$mail->Username = 'pololance@gmail.com';
$mail->Password = 'Cms1nams!';

$mail->Subject = trim("Email Verification");

$mail->SetFrom('pololance@gmail.com', 'Lance');
$mail->AddAddress($email);
$mail->MsgHTML($message);

try {
	$mail->send();
} catch (Exception $ex) {
	echo $msg = $ex->getMessage();
}
?>
