<?php 
    /*
    purpose : used to get all live categories 
    how to call : http://localhost:8080/android_batch_37/ws/category.php
    input: Nothing 
    output: 
    */
    $response = array();
    //step -1 select database server 
    $link = mysqli_connect("localhost:3306","root","");

    //step -2 select database 
    mysqli_select_db($link,"android_batch_34");
    $sql = "select id,title,photo from category";
    //step -3 run query 
    $table = mysqli_query($link,$sql);
    array_push($response,array("total"=>mysqli_num_rows($table)));
    while($row = mysqli_fetch_assoc($table))
    {
        array_push($response,$row);
    }
    array_unshift($response,array("error"=>"no"));
    echo json_encode($response);
?>
