<?php 
    /*
    purpose : used to get all live product of specific category 
    how to call : http://localhost:8080/android_batch_37/ws/product.php?categoryid=1
    input: categoryid=1 
    output: 
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"total":2},{"id":"1","title":"Acer Laptop","price":"100","photo":"acer.jpg"},{"id":"2","title":"dell laptop","price":"200","photo":"dell.jpg"}]
    */
    require_once("../inc/connection.php");
    extract($input);
    if(isset($categoryid)==false)
    {
        array_push($response,array("error"=>"input is missing"));
    }
    else 
    {
        $sql = "select id,title,price,photo from product where categoryid=$categoryid and isdeleted=0 and islive=1";
        $table = mysqli_query($link,$sql) or ReturnError(null,__LINE__);
        $total = mysqli_num_rows($table); //mysqli_num_rows how many rows query has fetched 
        array_push($response,array("total"=>$total));
        while($row=mysqli_fetch_assoc($table))
        {
            array_push($response,$row);
        }
        array_unshift($response,array("error"=>"no"));
        
    }
    echo json_encode($response);
?>
