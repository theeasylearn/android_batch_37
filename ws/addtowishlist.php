<?php 
    /*
    purpose : used to add product into wishlist 
    how to call : http://localhost:8080/android_batch_37/ws/addtowishlist.php?productid=1&usersid=1
    input: productid,usersid (required)
    output: 
    1) [{"error":"input is missing"}]
    2) 
    */
    require_once("../inc/connection.php");
    extract($input);
    if(isset($productid,$usersid)==false)
    {
        array_push($response,array("error"=>"input is missing"));
    }
    else //input is given
    {
        $sql = "select count(*) 'total_record' from wishlist where productid=$productid and usersid=$usersid";
        $table = mysqli_query($link,$sql) or ReturnError(null,__LINE__);
        $row=mysqli_fetch_assoc($table);
        if($row['total_record']==0)
        {
            $sql = "insert into wishlist (productid,usersid) values($productid,$usersid)";
            mysqli_query($link,$sql) or ReturnError(null,__LINE__);
        }
        array_push($response,array("message"=>"Wishlist updated"));
        array_unshift($response,array("error"=>"no"));
    }
    echo json_encode($response);
?>
