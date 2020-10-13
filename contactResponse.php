<?php
// Includes
include 'functions.php';

define ('SECRET_KEY', '');

if($_POST) {
    function getCaptcha($secretkey) {
        $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRET_KEY . "&response={$secretkey}");
        $Return = json_decode($Response);
        return $Return;
    }
    $Return = getCaptcha($_POST['g-recaptcha-response']);
    //var_dump($Return);
    if($Return->success == true && $Return->score > 0.5) {
        echo "Thanks for the message, I'll be in touch shortly.";
    } else {
       echo "You're a robot!";
    }
}

//error_reporting(E_ALL);

// Escape form data and store in variables
$name = mssql_escape($_POST['name']);
$email  = mssql_escape($_POST['email']);
$message = mssql_escape($_POST['message']);

// Build email body in html format
$messagebody = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>George Hatzi - Front-end developer</title></head><body><table cellspacing="0" style="border:1px solid #EAEAEA;width:100%;background:#FFF;"><tr style="background-color:#E1E1E1;padding:10px;"><td style="font-weight:bold;width:20%;">Name:</td><td style="width:80%;">'.$name.'</td></tr><tr style="padding:10px;"><td style="font-weight:bold;width:20%;">E-mail:</td><td style="width:80%;">'.$email.'</td></tr><tr style="background-color:#E1E1E1;padding:10px;"><td style="font-weight:bold;width:20%;">Message:</td><td style="width:80%;">'.$message.'</td></tr></table></body></html>';

$messagebody = stripslashes($messagebody);

//Set up mail
//ini_set('sendmail_from','');
$recipientEmail = "";

$recipient = $recipientEmail;
// Create email subject from senders name
$subject = "Message from " . $name;
// Escape bad data in email subject
$subject = stripslashes($subject);
$mailheaders = 'From: '. $name . "\r\n" . 'X-Mailer: PHP/' . "\r\n" . 'MIME-Version: 1.0' . "\r\n";
$mailheaders .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
$mailheaders .= 'Reply-To: ' . $email;

mail($recipient, $subject, $messagebody, $mailheaders);
?>
