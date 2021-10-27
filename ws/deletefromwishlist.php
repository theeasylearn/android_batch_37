<?php
/*
    purpose : used to delete product from wishlist 
    how to call : http://localhost:8080/android_batch_37/ws/deletefromwishlist.php?wishlistid=1
    input: wishlistid (required)
    output: 
    1) [{"error":"input is missing"}]
    2) 
    */
require_once("../inc/connection.php");
extract($input);
if (isset($wishlistid) == false) {
    array_push($response, array("error" => "input is missing"));
} else //input is given
{
    $sql = "delete from wishlist where id=$wishlistid";
    mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    array_push($response, array("message" => "Product removed from wishlist"));
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response);
