<?php 
    /*
        simple web service that returns fruit names 
    */
    $response = array(); //empty array 
    $fruits = array("Apple","Banana","Mango","Orange","Kiwi");

    //add fruits array into response array 
    array_push($response,array("fruits"=>$fruits));
    echo json_encode($response);
?>