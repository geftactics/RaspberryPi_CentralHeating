<?php
// temp.php
// Sets the activation temperature

if (!is_numeric($_GET[temperature]))
  die("Error");


file_put_contents("schedule/tempCold", $_GET[temperature]);

header("location: index.php");


?>
