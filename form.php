<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);  

echo <<<END
<form method="POST" action="folders.php">
  <h1>e-mail address: </h1>
  <input type="text" name="username" value=""/>
  <p>
  <h1>password: </h1>
  <input type="text" name="password" value=""/>
  <input type="submit"/>
</form>
<hr>
END;
?>
