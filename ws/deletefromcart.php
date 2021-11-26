<?php
/*
    purpose : used to delete product from cart 
    how to call : http://localhost:8080/android_batch_37/ws/deletefromcart.php?cartid=1
    input: cartid (required)
    output:   
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"message":"Product removed from cart"}]
    */
require_once("../inc/connection.php");
extract($input);
if (isset($cartid) == false) {
    array_push($response, array("error" => "input is missing"));
} else //input is given
{
    $sql = "delete from cart where id=$cartid";
    mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    array_push($response, array("message" => "Product removed from cart"));
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response);
