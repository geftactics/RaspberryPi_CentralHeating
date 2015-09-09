<?
// ios.php
// Status and boots functionality, optimised for iOS devices
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 TRANSITIONAL//EN">
<html>
	<head>
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
		<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="javascript/functions.js" type="text/javascript"></script>
		<link rel="apple-touch-icon" href="homescreen.png"/>
		<!-- <link href="startup.png" rel="apple-touch-startup-image" />	-->
		<title>Central Heating</title>
	</head>
	<body>
	
		<div id="topbar">
			<div id="title">Central Heating Control</div>
		</div>

		<? include("functions.php"); ?>

<table border="0" align="center">
<tr><td width="150"><span class="graytitle">Heating Status:</span> </td><td width="130" bgcolor="<?= getHeatingColor(); ?>">&nbsp;<?= getHeatingStatus(); ?></td><td width="20"></td></tr>
<tr><td><span class="graytitle">Boost Status: </span></td><td bgcolor="<?= getBoostColor(); ?>">&nbsp;<?= getBoostStatus(); ?> <? if (isBoostActive()) { echo "("; echo getBoostRemaining(); echo "m left)"; } ?></td><td></td></tr>
<tr><td><span class="graytitle">Next Change: </span></td><td bgcolor="#9C9C9C">&nbsp;<?= getNextChange(); ?></td><td></td></tr>
<tr><td><span class="graytitle">Ext temp: </span></td><td bgcolor="#9C9C9C">&nbsp;<?= getTemp(); ?>&deg;C</td><td></td></tr>
</table>

<br/>

		<form action="boost.php">
		<ul class="pageitem">
			<li class="button">
<?

$tempCold = getTempCold();

if (isBoostActive())
	echo ("				<input name='Submit' type='submit' value='Cancel Boost' />");
else
	echo ("				<input name='Submit' type='submit' value='Enable Boost' />");
?>
			</li>
		</ul>
		</form>




		<form action='temp.php'>
			<span class="graytitle">Activation below:</span>
			<ul class="pageitem">
				<li class="select">
					<select name="temp" onchange="this.form.submit()">
<?
        for($i=20;$i>=0;$i--)
                if($i==$tempCold)
                        echo ("<option selected value=\"$i\">$i&deg;C</option>\n");
                else
                        echo ("<option value=\"$i\">$i&deg;C</option>\n");
?>


					</select>
				<span class="arrow"></span>
				</li>
			</ul>
		</form>
		
		
		<span class="noeffect" style="font-size:7pt">

<?
$file = file("schedule/log");
$file = array_reverse($file);

if (sizeOf($file) > 10)
        $size = 10;
else
        $size = sizeOf($file);

for ($i = 0; $i < $size; $i++)
    echo "&nbsp;".$file[$i]."<br />";

?>

		</span>
		

	</body>
</html>
