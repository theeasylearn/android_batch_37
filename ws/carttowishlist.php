<?php
/*
    purpose : used to add move product from cart to wishlist 
    how to call : http://localhost:8080/android_batch_37/ws/carttowishlist.php?productid=2&usersid=1&cartid=2
    input: productid,usersid,cartid (required)
    output: 
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"message":"Product moved to wishlist"}]
    */
require_once("../inc/connection.php");
extract($input);
if (isset($productid, $usersid, $cartid) == false) {
    array_push($response, array("error" => "input is missing"));
} else //input is given
{
    $sql = "delete from cart where id=$cartid";
    mysqli_query($link, $sql) or ReturnError(null, __LINE__);


    $sql = "select count(*) 'total_record' from wishlist where productid=$productid and usersid=$usersid";
    $table = mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    $row = mysqli_fetch_assoc($table);
    if ($row['total_record'] == 0) {
        $sql = "insert into wishlist (productid,usersid) values($productid,$usersid)";
        mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    }
    array_push($response, array("message" => "Product moved to wishlist"));
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response);
