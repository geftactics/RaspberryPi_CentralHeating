<!DOCTYPE html><? include("functions.php"); ?>
<html>
<head>
    <meta charset="utf-8">
    <title>Central Heating</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>

	<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand">Central Heating</a>
			</div>
			<div class="collapse navbar-collapse" id="navbarCollapse">
			</div>
		</div>
	</nav>

	<br/><br/><br/><br/>

	<div class="container">

		<div class="row">
			<div class="col-xs-3">Heating Status:</div>
			<div class="col-xs-3"><span class="label label-default"><?= getHeatingStatus(); ?></span></div>
			<div class="col-xs-6"></div>
		</div>
		<div class="row">
			<div class="col-xs-3">Boost Status:</div>
			<div class="col-xs-3"><span class="label label-default"><?= getBoostStatus(); ?>  <? if (isBoostActive()) { echo "(" . getBoostRemaining() . "m left)"; } ?></span></div>
			<div class="col-xs-6"></div>
		</div>
		<div class="row">
			<div class="col-xs-3">Next Change:</div>
			<div class="col-xs-3"><span class="label label-primary"><?= getNextChange(); ?></span></div>
			<div class="col-xs-6"></div>
		</div>
		<div class="row">
			<div class="col-xs-3">Ext Temp:</div>
			<div class="col-xs-3"><span class="label label-primary"><?= getTemp(); ?>&deg;C</span></div>
			<div class="col-xs-6"></div>
		</div>
		<div class="row">
			<div class="col-xs-12"> &nbsp;</div>
		</div>



		Boost button<br/>activation setting



		<div class="hidden-xs">
		<table cellpadding="0" cellspacing="0">
		<?
		$dayName = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");

		echo "\t<tr>\n\t\t\t\t<td></td>\n";

		for ($hr = 0; $hr <= 23; $hr++)
			echo "\t\t\t\t<td colspan='4' align='left'>$hr</td>\n";
		echo "\t\t\t</tr>\n";

		for ($dy = 0; $dy < 7; $dy++) { //dayrow loop
		  echo "\t\t\t<tr>\n\t\t\t\t<td>$dayName[$dy]</td>\n";
		  for ($hr = 0; $hr <= 23; $hr++) { //hour loop
		    for ($mi = 0; $mi <= 45; $mi=$mi+15) { // quarter hour loops
			$file = "schedule/" . $dy . "-" . $hr . "-" . $mi;
			if (file_exists($file))
		   	  $color="label-danger";
			else
			  $color="label-info";
			echo "\t\t\t\t<td class='$color' onclick=\"window.location='toggle.php?day=$dy&hour=$hr&min=$mi'\" style='cursor:pointer;border: 1px solid white'>&nbsp;&nbsp;</td>\n";
		    }
		  }
		  echo "\t\t\t</tr>\n";
		}
		?>
		</table>
		</div>


		<div class="row">
			<div class="col-xs-12"> &nbsp;</div>
		</div>


		<div class="panel panel-default">
			<div class="panel-body">
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
			</div>
		</div>


	</div>

    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
