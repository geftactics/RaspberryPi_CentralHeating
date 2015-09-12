<?
// temp.php
// Sets the activation temperature

if (!is_numeric($_GET[temp]))
  die("Error");


file_put_contents("schedule/tempCold", $_GET[temp]);

header("location: index.php");


?>
