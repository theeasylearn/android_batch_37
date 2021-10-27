<?php 
    /*
    purpose : used to get all live categories 
    how to call : http://localhost:8080/android_batch_37/ws/category.php
    input: Nothing 
    output: [{"error":"no"},{"total":6},{"id":"1","title":"laptop","photo":"laptop.jpg"},{"id":"2","title":"mobile","photo":"mobile.jpg"},{"id":"3","title":"book","photo":"books.jpg"},{"id":"4","title":"Cookies & waffers","photo":"Cookies.jpg"},{"id":"5","title":"Washing Powders","photo":"washing_powders.jpg"},{"id":"6","title":"shampoo","photo":"shampoo.jpg"}]
    */
    require_once("../inc/connection.php");
    $sql = "select id,title,photo from category where islive=1 and isdeleted=0 order by title";
    //step -3 run query 
    $table = mysqli_query($link,$sql) or ReturnError(null,__LINE__);
    array_push($response,array("total"=>mysqli_num_rows($table)));
    while($row = mysqli_fetch_assoc($table))
    {
        array_push($response,$row);
    }
    array_unshift($response,array("error"=>"no"));
    echo json_encode($response);
?>
