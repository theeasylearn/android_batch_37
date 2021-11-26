<?php 
    /*
    purpose : used to get all product added into cart by specific user
    how to call : http://localhost:8080/android_batch_37/ws/cart.php?usersid=1
    input: usersid=1
    output: 
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"total":0}]
    3)[{"error":"no"},{"total":2},{"id":"6","productid":"1","title":"Acer Laptop","price":"100","photo":"acer.jpg","quantity":"1"},{"id":"4","productid":"2","title":"dell laptop","price":"200","photo":"dell.jpg","quantity":"1"}]
    */
    require_once("../inc/connection.php");
    extract($input);
    if(isset($usersid)==false)
    {
        array_push($response,array("error"=>"input is missing"));
    }
    else 
    {
        $sql = "select c.id,p.id 'productid',title,p.price,photo,c.quantity from product p,cart c where productid=p.id and usersid=$usersid and billid=0 order by title";
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
