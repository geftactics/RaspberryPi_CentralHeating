<?php
	// manager.php
	// Called every minuite via cron. Performs the logic to decide if heating should be turned on or off

	chdir(dirname(__FILE__));

	include("functions.php");

	$heatingActive = isHeatingActive();

	// Boost
	$boostExit = "cancelled";
	if(isBoostActive()) {
		$heatingBoost = true;
		if(getBoostRemaining() <= 0) {
			file_put_contents($logFile, date("d/m/y @ H:i") . " Boost Expired\n", FILE_APPEND);
			$boostExit = "expired";
			unlink("schedule/boost");
			$heatingBoost = false;
		}

	}
	else {
		$heatingBoost = false;
	}


	// Timer
	$now = date("N")-1 . "-" . date("G") . "-" . floor(date("i")/15)*15;
	if(file_exists("schedule/" . $now)) {
		$heating = true;
	}
	else {
		$heating = false;
	}


	// Weather
	$tempNow = getTemp();
	$tempCold = getTempCold();
	if($tempNow <= $tempCold) {
		$weatherCold = true;
	}
	else {
		$weatherCold = false;
	}




	// Logic
	if($heatingBoost) {
		if(!$heatingActive) {
			file_put_contents($gpioFile, $gpioOn);
			file_put_contents($logFile, date("d/m/y @ H:i") . " Heating On (Boost Active)\n", FILE_APPEND);
		}
		exit();
	}
	if($heating && $weatherCold) {
		if(!$heatingActive) {
			file_put_contents($gpioFile, $gpioOn);
			file_put_contents($logFile, date("d/m/y @ H:i") . " Heating On (Timer active & temp below $tempCold C)\n", FILE_APPEND);
		}
		exit();
	}
	if(!$weatherCold && !$heating) {
		if($heatingActive) {
			file_put_contents($gpioFile, $gpioOff);
			file_put_contents($logFile, date("d/m/y @ H:i") . " Heating Off (Timer inactive & temp above $tempCold C)\n", FILE_APPEND);
 		}
		exit();
	}
	if($weatherCold && !$heating) {
		if($heatingActive) {
			file_put_contents($gpioFile, $gpioOff);
			file_put_contents($logFile, date("d/m/y @ H:i") . " Heating Off (Timer inactive)\n", FILE_APPEND);
		}
		exit();
	}
	if(!$weatherCold && $heating) {
		if($heatingActive) {
			file_put_contents($gpioFile, $gpioOff);
			file_put_contents($logFile, date("d/m/y @ H:i") . " Heating Off (Temp above $tempCold C)\n", FILE_APPEND);
		}
		exit();
	}
	if(!$heatingBoost) { // not sure if this ever gets triggered?
		if($heatingActive) {
			file_put_contents($gpioFile, $gpioOff);
			file_put_contents($logFile, date("d/m/y @ H:i") . " Heating Off (Boost $boostExit)\n", FILE_APPEND);
		}
		exit();
	}

	file_put_contents($logFile, date("d/m/y @ H:i") . "ERROR: We shouldn't get here!... heatingboost=$heatingBoost / heatingActive=$heatingActive /  weatherCold=$weatherCold / heating=$heating ", FILE_APPEND);


?>
