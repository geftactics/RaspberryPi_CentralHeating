<?php

// How many mins we want to boost feature to run for
$boostTime = 60;

// The ID for your local BBC weather feed. We get the current temperature from here
$bbcWeatherID = "2633990";

// Location of log file
$logFile ="schedule/log";

// GPIO pin that controls central heating. If you change this, also update /etc/rc.local
$gpioFile = "/sys/class/gpio/gpio4/value";

// GPIO on value
$gpioOn = 0;

// GPIO off value
$gpioOff = 1;

?>
