<?php
// toggle.php
// When schedule is being updated this will enable or disable heating in one of the given 15min timeslots

if (!is_numeric($_GET['day']) OR !is_numeric($_GET['hour']) OR !is_numeric($_GET['min']))
  die("Error");


$file = "schedule/" . $_GET['day'] . "-" . $_GET['hour'] . "-" . $_GET['min'];


if (file_exists($file))
    unlink($file);
else
    touch($file);


header("location: index.php");


?>
