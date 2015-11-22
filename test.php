<?

	include("functions.php");

        if (file_exists("schedule/boost")) {
                $startTime = file_get_contents("schedule/boost");
                $now = date("U");
                $runtime = $now - $startTime;
                global $boostTime;
		$boostTime = $boostTime*60;
                $result = round(($boostTime - $runtime)/60);

		echo("\nStart Time:\t$startTime");
		echo("\nNow:\t\t$now");
		echo("\nBoost Time:\t$boostTime");
		echo("\nResult:\t\t$result");
        }
        else
                echo "Boost inaCTIVE";



?>

