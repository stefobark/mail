<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//connect to mysql
$mysqli  = mysqli_connect('127.0.0.1', 'root', '', 'test', '3306');

//Your gmail email address and password
$username = 'someone@gmail.com';
$password = 'password';

//Which folders or label do you want to access? - Example: INBOX, All Mail, Trash, labelname 
//Note: It is case sensitive
$imapmainbox = "contact-us";

//Select messagestatus as ALL or UNSEEN which is the unread email
$messagestatus = "ALL";

//-------------------------------------------------------------------

//Gmail Connection String
$imapaddress = "{imap.gmail.com:993/imap/ssl}";

//Gmail host with folder
$hostname = $imapaddress . $imapmainbox;

//Open the connection
$connection = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

//Grab all the emails inside the inbox
$emails = imap_search($connection,$messagestatus);

//number of emails in the inbox
$totalemails = imap_num_msg($connection);
  
echo "Total Emails: " . $totalemails . "<br>:::::::::::::::::::::::::<br>";
  
if($emails) {
  
  //sort emails by newest first
  rsort($emails);
  
  //loop through every email in the inbox
  foreach($emails as $email_number) {
    
	//get some header info for subject, from, and date.. imag_fetch_overview (which was in the example I used for this) just returns true or false
    $headerinfo = imap_headerinfo($connection, $email_number);


    //Because attachments can be problematic this logic will default to skipping the attachments    
    $message = imap_fetchbody($connection,$email_number,1.1);
         if ($message == "") { // no attachments is the usual cause of this
          $message = imap_fetchbody($connection, $email_number, 1);
    }
 
	$from = $headerinfo->{'fromaddress'};
	$subject = $headerinfo->{'subject'};
	$date = $headerinfo->{'date'};
	$fmessage = quoted_printable_decode($message);

//This is where you would want to start parsing your emails, send parts of the email into a database or trigger something fun to happen based on the emails.
$mysqli->query("INSERT INTO emails (sender, subject, date, message) VALUES ('$from','$subject', '$date', '$fmessage')");
printf("Affected rows (INSERT): %d<br>", $mysqli->affected_rows);
  }  
} 

// close the connection
imap_close($connection);
?>
