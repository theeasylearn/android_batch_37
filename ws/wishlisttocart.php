<?php
/*
    purpose : used to add move product from wishlist to cart 
    how to call : http://localhost:8080/android_batch_37/ws/wishlisttocart.php?productid=2&usersid=1&wishlistid=5
    input: productid,usersid,wishlist (required)
    output: 
    1) [{"error":"input is missing"}]
    1) [{"error":"no"},{"message":"Product moved to cart"}]
    */
require_once("../inc/connection.php");
extract($input);
if (isset($productid, $usersid, $wishlistid) == false) {
    array_push($response, array("error" => "input is missing"));
} else //input is given
{
    $sql = "delete from wishlist where id=$wishlistid";
    mysqli_query($link, $sql) or ReturnError(null, __LINE__);

    $sql = "select count(*) 'total_record' from cart where productid=$productid and usersid=$usersid and billid=0";
    $table = mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    $row = mysqli_fetch_assoc($table);
    if ($row['total_record'] == 0) {
        $sql = "insert into cart (productid,usersid,price,billid,quantity) values($productid,$usersid,0,0,1)";
        mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    }
    array_push($response, array("message" => "Product moved to cart"));
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response);
