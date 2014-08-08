<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>G(e)mails</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">
  </head>
  <body role="document">
<?php
session_start();
//connect to mysql
$mysqli  = mysqli_connect('127.0.0.1', 'root', '', 'test', '3306');

//Your gmail email address and password
$username = $_SESSION["username"];
$password = $_SESSION["password"];

//Select messagestatus as ALL or UNSEEN which is the unread email
$messagestatus = "ALL";

//-------------------------------------------------------------------

//Gmail host with folder
$hostname = $_GET["folder"];

//Open the connection
$connection = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

//Grab all the emails inside the inbox
$emails = imap_search($connection,$messagestatus);

//number of emails in the inbox
$totalemails = imap_num_msg($connection);
  
echo "<div class='container'>
	
	<div class='col-md-6'><h1 class='bg-primary'>Total Emails: " . $totalemails . "</h1></div></div>";
  
if($emails) {
  
  //sort emails by newest first
  rsort($emails);
  
  //loop through every email in the inbox
  foreach($emails as $email_number) {
    
	//get some header info for subject, from, and date.. imap_fetch_overview (which was in the example I used for this) just returns true or false
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

	echo <<<END

	<div class='container'>
	<div class='col-md-6'>
	<h4>Inserting:<br><br>
	<h4>Sender:</h4>  $from <br><br>
	<h4>Subject:</h4> $subject <br><br>
	<h4>Date:</h4> $date <br><br>
	<h4>Message:</h4> $fmessage <br><br>
	</div></div>
END;

/* Prepared statement, stage 1: prepare */
if (!($stmt = $mysqli->prepare("INSERT INTO emails (sender, subject, date, message) VALUES (?,?,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->bind_param("ssss", $from, $subject, $date, $fmessage)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
  }  
} 

// close the connection
imap_close($connection);

?>
