<?php 
    /*
        simple web service that returns current day month year
    */
    date_default_timezone_set("asia/kolkata");
    $response = array(); //empty array 
    $day = date("d"); //current day of month 
    $month = date("m"); //current  month of year
    $year = date("Y"); //current year in 4 digit format


    array_push($response,array("day"=>$day));
    array_push($response,array("month"=>$month));
    array_push($response,array("year"=>$year));

    $hour = date("h"); //return hour of the day 
    $minute = date("i"); //return minutes of the day 
    $second = date("s"); //return seconds of the day 
    
    array_push($response,array("hour"=>$hour));
    array_push($response,array("minute"=>$minute));
    array_push($response,array("second"=>$second));
    array_unshift($response,array("error"=>"no"));

    echo json_encode($response);
?>