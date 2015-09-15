<?

	include("functions.php");

        // Start from current point to end of week
        $minskip = 55;
        $hourskip = date("G");
        $dayskip = date("N")-1;

        for ($day = 0; $day < 7; $day++)
                for ($hour = 0; $hour <= 23; $hour++)
                        for ($min = 0; $min <= 60; $min=$min+15){
                                if ($day >= $dayskip && $hour >= $hourskip && $min >= $minskip){
                                        $minskip=0;
                                        $hourskip=0;
                                        $dayskip=0;
                                        $file = "schedule/" . $day . "-" . $hour . "-" . $min;
                                        echo "---" . $file . "\n";
                                        if($min==0) $min="00";
                                        if (isHeatingActive()){
                                                if (!file_exists($file))
                                                        echo "Off at $hour:$min";
                                        }
                                        else {
                                                if (file_exists($file))
                                                        echo "On at $hour:$min";
                                        }
                                }
			}



?>
