<?
// index.php
// Main page for setting schedule and temperature threshold

if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod'))
 {
  header('Location: /heating/ios.php');
  exit();
}
?>
<html><head>
 <style>
   body {font-family:arial}
   td {font-family:arial;font-size:10pt}
 </style>
</head>

<body>

<? include("functions.php"); ?>

<h1>Central Heating Control</h1>

<table border="0">
<tr><td bgcolor="#E3E3E3" width="110"><b>Heating Status:</b> </td><td width="100" bgcolor="<?= getHeatingColor(); ?>">&nbsp;<?= getHeatingStatus(); ?></td></tr>
<tr><td bgcolor="#E3E3E3"><b>Boost Status: </b></td><td bgcolor="<?= getBoostColor(); ?>">&nbsp;<?= getBoostStatus(); ?>  <? if (isBoostActive()) { echo "("; echo getBoostRemaining(); echo "m left)"; } ?></td></tr>
<tr><td bgcolor="#E3E3E3"><b>Next Change: </b></td><td bgcolor="#9C9C9C">&nbsp;<?= getNextChange(); ?></td></tr>
<tr><td bgcolor="#E3E3E3"><b>Ext temp: </b></td><td bgcolor="#9C9C9C">&nbsp;<?= getTemp(); ?>&deg;C</td></tr>
</table>
<br/>

<?

$tempCold = getTempCold();

if (isBoostActive())
	echo ("<form action='boost.php'><input type='submit' value='Cancel Boost'></form><br/>");
else
	echo ("<form action='boost.php'><input type='submit' value='Enable Boost'></form><br/>");
?>

<form action='temp.php'>
Activation below:
<select name="temp" onchange="this.form.submit()">
<?
	for($i=20;$i>=0;$i--)
		if($i==$tempCold)
			echo ("<option selected value=\"$i\">$i&deg;C</option>\n");
		else
			echo ("<option value=\"$i\">$i&deg;C</option>\n");
?>
</select>
</form>

<br/><br/><br/>

<table cellpadding="0" cellspacing="0"> 
<?
$dayName = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");

echo "  <tr>\n    <td></td>\n";
for ($hr = 0; $hr <= 23; $hr++)
echo "    <td colspan='4' align='left'>$hr</td>\n";


for ($dy = 0; $dy < 7; $dy++) { //dayrow loop

  echo "  <tr>\n    <td>$dayName[$dy]</td>\n";

  for ($hr = 0; $hr <= 23; $hr++) { //hour loop

    for ($mi = 0; $mi <= 45; $mi=$mi+15) { // quarter hour loops

	$file = "schedule/" . $dy . "-" . $hr . "-" . $mi;
	if (file_exists($file))
   	  $color="darkblue";
	else
	  $color="lightblue";
	
	echo "    <td bgcolor='$color' onclick=\"window.location='toggle.php?day=$dy&hour=$hr&min=$mi'\" style='cursor:pointer;border: 1px solid white'>&nbsp;&nbsp;</td>\n";

    }

  }
  echo "  </tr>";

}  

?>

</table>

<br/>

<?
$file = file("schedule/log");
$file = array_reverse($file);

if (sizeOf($file) > 10)
	$size = 10;
else
	$size = sizeOf($file);

for ($i = 0; $i < $size; $i++)
    echo $file[$i]."<br />";

?>

</body>
</html>
