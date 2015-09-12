<?

include("functions.php");

        // Start from current point to end of week
        $minskip = date("i");
        $dayskip = date("N")-1;
        $hourskip = date("G");
        for ($day = 0; $day < 7; $day++)
                for ($hour = 0; $hour <= 23; $hour++)
                        for ($min = 0; $min <= 45; $min=$min+15)
                                if ($day >= $dayskip && $hour >= $hourskip && $min >= $minskip){ //problem with minskip in 45-00 min segment.
                                        $minskip=0;
                                        $hourskip=0;
                                        $daykip=0;
                                        $file = "schedule/" . $day . "-" . $hour . "-" . $min;
                                        echo $file . "\n";
                                        if($min==0) $min="00";
                                        if (isHeatingActive()){
                                                if (!file_exists($file))
                                                        echo "\nOff at $hour:$min";
                                        }
                                        else {
                                                if (file_exists($file))
                                                        echo "\nOn at $hour:$min";
                                        }
                                }




?>
