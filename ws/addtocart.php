<?php
    /*
    purpose : used to add product into cart 
    how to call : http://localhost:8080/android_batch_37/ws/addtocart.php?productid=1&usersid=1
    input: productid,usersid (required) 
    output: 
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"message":"Product added into cart"}]
    3) [{"error":"no"},{"message":"Cart updated"}]
    */
    require_once("../inc/connection.php");
    extract($input);
    if(isset($productid,$usersid)==false)
    {
        array_push($response,array("error"=>"input is missing"));
    }
    else //input is given
    {
        $sql = "select count(*) 'total_record' from cart where productid=$productid and usersid=$usersid and billid=0";
        $table = mysqli_query($link,$sql) or ReturnError(null,__LINE__);
        $row=mysqli_fetch_assoc($table);
        if($row['total_record']==0) //cart has no product for users
        {
            $sql = "insert into cart (productid,usersid,price,billid,quantity) values($productid,$usersid,0,0,1)";
            mysqli_query($link,$sql) or ReturnError(null,__LINE__);
            array_push($response,array("message"=>"Product added into cart"));
        }
        else //cart has product for users
        {
            $sql = "update cart set quantity=quantity+1  where productid=$productid and usersid=$usersid and billid=0";
            mysqli_query($link,$sql) or ReturnError(null,__LINE__);
            array_push($response,array("message"=>"Cart updated"));
        }
        array_unshift($response,array("error"=>"no"));
    }
    echo json_encode($response);
?>
