<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);  
$host = "{imap.gmail.com:993/imap/ssl}";
$user = $_POST["username"];
$pass = $_POST["password"];
 
if ($mbox=imap_open( $host, $user, $pass ))
{
$imap_obj = imap_check($mbox);
echo "<h1>CONNECTED TO IMAP HOST</h1><h2>$host (".  $imap_obj->Nmsgs  .")<h2>";
} else
{
echo "<h1>FAILED TO CONNECT TO IMAP HOST!</h1>\n";
die;
}
 
echo "<h3>IMAP LIST OF FOLDERS</h3>";
$folders = imap_list($mbox, $host, "*");
echo "<ul>";
foreach ($folders as $folder) {
echo '<li><a href="mail.php?folder=' . $folder . '&func=view">' . imap_utf7_decode($folder) . '</a></li>';
}
echo "</ul><br><br>";
echo "Now, copy and paste one of these folder names (the whole string) into this field:<br><br>"; 

echo <<<END
<form method="POST" action="gmail.php">
  <h1>folder: </h1>
  <input type="text" name="folder" value=""/>
  <p>
  <input type="hidden" name="username" value="$user" />
  <input type="hidden" name="password" value="$pass" />
  <input type="submit"/>
</form>
<hr><br>
After hitting 'submit' emails will start being inserted. Remember to <br>
<strong>edit the db connection parameters</strong> 
to match your setup. This next step could take a while. <br>
If you're curious, and want to make sure things are happening, <br>
open up the command line interface and select from the 'emails' table. You'll see it growing.

END;
imap_close($mbox);

?>
