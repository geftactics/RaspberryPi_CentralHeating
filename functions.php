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

	// check rest of today
		for ($dy = date("N")-1; $dy < 7; $dy++)
		for ($hr = date("G"); $hr <= 23; $hr++)
			for ($mi = 0; $mi <= 45; $mi=$mi+15) { // quarter hour loops
				$file = "schedule/" . $dy . "-" . $hr . "-" . $mi;
				if ($mi == "0") $mi = "00";
				if (isHeatingActive()) {
					if (!file_exists($file))
						return "Off at $hr:$mi";
				}
				else {
					if (file_exists($file))
						return "On at $hr:$mi";
				}
			}

	// check from tomorrow
	for ($dy = date("N"); $dy < 7; $dy++)
			for ($hr = 0; $hr <= 23; $hr++)
				for ($mi = 0; $mi <= 45; $mi=$mi+15) { // quarter hour loops
				$file = "schedule/" . $dy . "-" . $hr . "-" . $mi;
				if ($mi == "0") $mi = "00";
				if (isHeatingActive()) {
					if (!file_exists($file))
						return "Off at $hr:$mi";
				}
				else {
					if (file_exists($file))
						return "On at $hr:$mi";
					}
				}

	// check from start of week
	for ($dy = 0; $dy < 7; $dy++)
		for ($hr = 0; $hr <= 23; $hr++)
			for ($mi = 0; $mi <= 45; $mi=$mi+15) { // quarter hour loops
				$file = "schedule/" . $dy . "-" . $hr . "-" . $mi;
				if ($mi == "0") $mi = "00";
				if (isHeatingActive()) {
					if (!file_exists($file))
						return "Off at $hr:$mi";
				}
				else {
					if (file_exists($file))
						return "On at $hr:$mi";
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
		return "Orange";
	else
		return "#9C9C9C";
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
		return "Orange";
	else
		return "#9C9C9C";
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
