<?
	// boost.php
	// Activate or cancel the heating boost feature

	include("functions.php");

	if(isBoostActive()) {
		unlink("schedule/boost");
		file_put_contents($logFile, date("d/m/y @ H:i") . " Boost Cancelled\n", FILE_APPEND);
		file_put_contents($gpioFile, $gpioOff);
	}
	else {
		file_put_contents("schedule/boost", date("omdHi"));
		file_put_contents($logFile, date("d/m/y @ H:i") . " Boost Activated\n", FILE_APPEND);
		file_put_contents($gpioFile, $gpioOn);
	}

	header("Location: /heating/index.php");

?>
