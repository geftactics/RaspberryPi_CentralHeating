<?

// functions.php
// Bulk of code and functions used throughout the system
// If you want to use a current temperatre from alternative source, edit the getTemp() function below.


include("config.php");


// Enable debugging
error_reporting(E_ALL);
ini_set('display_errors', true);

function getTemp() {
	global $bbcWeatherID;
	$url = "http://open.live.bbc.co.uk/weather/feeds/en/" . $bbcWeatherID . "/observations.rss";
	$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
	$xml = file_get_contents($url, false, $context);
	$xml = simplexml_load_string($xml);
	//echo "<pre>";
	//print_r($xml);
	//echo "</pre>";
	$k = $xml->channel->item->title;
	preg_match('/, (\d+)/', $k, $matches);
	return $matches[1];
}


function getNextChange() {

	$dowMap = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');

	if (isBoostActive())
		return "Boost end " . getBoostRemaining() . " min";

	// Start from current point to end of week
	$minskip = date("i");
	$hourskip = date("G");
	$dayskip = date("N")-1;
	for ($day = 0; $day < 7; $day++)
		for ($hour = 0; $hour <= 23; $hour++)
			for ($min = 0; $min <= 45; $min=$min+15)
				if ($day >= $dayskip && $hour >= $hourskip && $min >= $minskip){ 
					$minskip=0;
					$hourskip=0;
					$dayskip=0;
					$file = "schedule/" . $day . "-" . $hour . "-" . $min;
					//echo $file . "\n";
					if($min==0) $min="00";
					if (isHeatingActive()){
						if (!file_exists($file))
							return "Off at $hour:$min";
					}
					else {
						if (file_exists($file))
							return "On at $hour:$min";
					}
				}

	// Start from beginning of week to current point
	$minskip = date("i");
	$hourskip = date("G");
	$dayskip = date("N")-1;
	for ($day = 0; $day < 7; $day++)
		for ($hour = 0; $hour <= 23; $hour++)
			for ($min = 0; $min <= 45; $min=$min+15)
				if ($day <= $dayskip && $hour <= $hourskip && $min <= $minskip) {
					$minskip=0;
					$hourskip=0;
					$dayskip=0;
					$file = "schedule/" . $day . "-" . $hour . "-" . $min;
					if($min==0) $min="00";
					if (isHeatingActive()) {
						if (!file_exists($file))
							return "Off at $hour:$min (" . $dowMap[$day] . ")";
					}
					else {
						if (file_exists($file))
							return "On at $hour:$min (" . $dowMap[$day] . ")";
					}
				}
}



function isHeatingActive() {
	global $gpioFile, $gpioOn;
	$gpioStatus = file_get_contents($gpioFile);
	if($gpioStatus==$gpioOn)
		return true;
	else
		return false;
}

function getHeatingStatus() {
	if (isHeatingActive())
		return "On";
	else
		return "Off";
}

function getHeatingColor() {
	if (isHeatingActive())
		return "label-warning";
	else
		return "label-default";
}

function isBoostActive() {
	if (file_exists("schedule/boost"))
		return true;
	else
		return false;
}

function getBoostStatus() {
	if (isBoostActive())
		return "Active";
	else
		return "Inactive";
}

function getBoostColor() {
	if (isBoostActive())
		return "label-warning";
	else
		return "label-default";
}

function getBoostRemaining() {
	if (file_exists("schedule/boost")) {
		$startTime = file_get_contents("schedule/boost");
		$now = date("omdHi");
		$runtime = $now - $startTime;
		global $boostTime;
		$result = $boostTime - $runtime;
		return $result;
	}
	else
		return 0;
}

function getTempCold() {
	$temp = file_get_contents("schedule/tempCold");
	return $temp;
}


?>
