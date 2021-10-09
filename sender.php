<?php

$email_to = "info@test.com";      // Replace with your email address
$result = "";

if(isset($_POST["submit"]))
{
	$contact_name = $_POST['name'];
	$contact_email_from = $_POST['email'];
	$contact_subject = $_POST['subject'];
	$contact_message = $_POST['message'];

	//Name Validation
    if(isset($contact_name) && strlen(trim($contact_name)) < 1) {
		$result = 'Error : Please enter your name.';
    }

	//Email Validation
   else if (empty($contact_email_from)) {
		$result = 'Error : Please enter your email id.';
    } elseif (!isValidEmail($contact_email_from)) {
		$result = 'Error : Please enter a valid email address.';
    }

	//Subject Validation
    else if(isset($contact_subject) && strlen(trim($contact_subject)) < 1) {
		$result = 'Error : Please enter the message subject.';
    }

	//Message Validation
    else if(isset($contact_message) && strlen(trim($contact_message)) < 1) {
		$result = 'Error : Please enter your message.';
    }
	
	else
	{
		$headers = "From: $contact_email_from" . "\r\n" . "MIME-Version: 1.0" . "\r\n" . "Content-type: text/html; charset=iso-8859-1";

		$subject = "You have a new message from your website (sabrinaschildcare.com)";

		$email_msg = "<div><p>Hello,</p><p>You have received a new message from your website (sabrinaschildcare.com), following are the details : </p><p>Name : $contact_name</p><p>Email : $contact_email_from</p><p>Subject : $contact_subject</p><p>Message : $contact_message</p></div>";
		
		$is_mail_sent = mail($email_to,$subject,$email_msg,$headers);

		if($is_mail_sent == false)
			$result = "Error : Email could not be sent, please try again later.";
		
		else
			$result = "Success : We have received your message, thank you.";

		echo $result;	
	}
} 
else
{	
	header("Location:index.html");
	exit;	
}	

function isValidEmail(){
	return true;
}
?>
