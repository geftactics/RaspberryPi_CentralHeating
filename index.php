<!DOCTYPE html><?= include("functions.php"); ?>
<html>
<head>
    <meta charset="utf-8">
    <title>Central Heating</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no">
    <link rel="apple-touch-icon" href="img/homescreen.png">
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

	<br/><br/><br/>

	<div class="container">

		<div class="row">
			<div class="col-xs-6 col-sm-3 col-md-2"><h4>Heating Status:</h4></div>
			<div class="col-xs-6 col-sm-3 col-md-2"><h4><span class="label <?= getHeatingColor(); ?> col-xs-12 col-md-12"><?= getHeatingStatus(); ?></span></h4></div>
			<div class="col-xs-0 col-sm-6 col-md-8"></div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-3 col-md-2"><h4>Boost Status:</h4></div>
			<div class="col-xs-6 col-sm-3 col-md-2"><h4><span class="label <?= getBoostColor(); ?> col-xs-12 col-md-12"><?= getBoostStatus(); ?>  <? if (isBoostActive()) { echo "(" . getBoostRemaining() . "m left)"; } ?></span></h4></div>
			<div class="col-xs-0 col-sm-6 col-md-8"></div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-3 col-md-2"><h4>Next Change:</h4></div>
			<div class="col-xs-6 col-sm-3 col-md-2"><h4><span class="label label-primary col-xs-12 col-md-12"><?= getNextChange(); ?></span></div>
			<div class="col-xs-0 col-sm-6 col-md-8"></div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-3 col-md-2"><h4>Ext Temp:</h4></div>
			<div class="col-xs-6 col-sm-3 col-md-2"><h4><span class="label label-primary col-xs-12 col-md-12"><?= getTemp(); ?>&deg;C</span></h4></div>
			<div class="col-xs-0 col-sm-6 col-md-8"></div>
		</div>

		<div class="row">
			<div class="col-xs-12"><br/></div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-4">
				<form action="boost.php">
				<?

				$tempCold = getTempCold();

				if (isBoostActive())
				        echo ("\t<button type=\"submit\" class=\"btn-danger btn-lg btn-block btn-default\">Cancel Boost</button>\n");
				else
				        echo ("\t<button type=\"submit\" class=\"btn-success btn-lg btn-block btn-default\">Enable Boost</button>\n");
				?>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12"><br/></div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-4">
				<form action="temp.php">
					<label for="activation">Activation below:</label>
					<select name="temp" class="form-control" onchange="this.form.submit()">
					<?
					        for($i=20;$i>=0;$i--)
					                if($i==$tempCold)
					                        echo ("\t\t\t\t\t\t<option selected value=\"$i\">$i&deg;C</option>\n");
					                else
					                        echo ("\t\t\t\t\t\t<option value=\"$i\">$i&deg;C</option>\n");
					?>
					</select>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12"><br/></div>
		</div>

		<div class="row hidden-xs">
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
