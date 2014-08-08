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
$host = "{imap.gmail.com:993/imap/ssl}";
$_SESSION['username'] = $_POST["username"];
$_SESSION['password'] = $_POST["password"];
 

if ($mbox=imap_open( $host, $_SESSION['username'], $_SESSION['password'] ))
{
$imap_obj = imap_check($mbox);
echo "  <div class='container'>
	<div class='col-md-6'>
	<h1>CONNECTED TO IMAP HOST</h1>
	<div class='panel panel-warning'>
            <div class='panel-heading'>
              <h3 class='panel-title'>$host <br><br>
		total emails:".  $imap_obj->Nmsgs  ."</h3>
		</div>
	</div>
	";
} else
{
echo "<div class='container'>
<div class='col-md-4'></div>
	
	<div class='col-md-4'>
	<h2>Get G(e)mails</h2>
          <div class='panel panel-warning'>
            <div class='panel-heading'>
              <h3 class='panel-title'>FAILED TO CONNECT TO IMAP HOST!</h3>
		</div>
		<div class='panel-body'>
              didn't work...
            </div>
		<div class='col-md-4'></div>	
		</div>
	</div>";
die;
}
 
echo "<h3>IMAP LIST OF FOLDERS</h3>";
$folders = imap_list($mbox, $host, "*");
echo "<ul>";
foreach ($folders as $folder) {
echo '<li><a href="gmail.php?folder=' . $folder . '">' . imap_utf7_decode($folder) . '</a></li>';
}
echo "</ul>";

echo <<<END

<div class="well">
<p>
After hitting 'Go' emails will start being inserted. <br<br>
Remember to <strong>edit the db connection parameters</strong> 
to match your setup. <br><br>
This next step could take a while.<br><br>
If you're curious, and want to make sure things are happening,
open up the command line interface and select from the 'emails' table.
<br><br>You'll see it growing.
</p>
</div>
</div>
</div>
END;
imap_close($mbox);

?>
</body>
</html>
