<?php 
    /*
    purpose : used to get all product added into wishlist by specific user
    how to call : http://localhost:8080/android_batch_37/ws/wishlist.php?usersid=1
    input: usersid=1
    output: 
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"total":0}]
    3) [{"error":"no"},{"total":1},{"id":"2","title":"dell laptop","price":"200","photo":"dell.jpg"}]
    */
    require_once("../inc/connection.php");
    extract($input);
    if(isset($usersid)==false)
    {
        array_push($response,array("error"=>"input is missing"));
    }
    else 
    {
        $sql = "select w.id,p.id,title,price,photo from product p,wishlist w where productid=p.id and usersid=$usersid order by title";
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
