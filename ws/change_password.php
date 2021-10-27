<?php
/*
    purpose : used to change password of buyer
    how to call : http://localhost:8080/android_batch_37/ws/change_password.php?old_password=123123&new_password=112233&id=1
    input: old_password,new_password,id (compulsory)
    output: 
      in case input is missing
     [{"error":"input is missing"}]
     [{"error":"no"},{"success":"no"},{"message":"invalid current password"}]
     [{"error":"no"},{"success":"yes"},{"message":"password changed"}]
*/
require_once("../inc/connection.php");
extract($input);
if (isset($id,$old_password,$new_password) == false) {
    array_push($response, array("error" => "input is missing"));
} else { //all inputs are given

    $sql = "select password from users where id=$id";
    $table = mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    $total = mysqli_num_rows($table); //count no of records in table
    if ($total == 0) //id no found
    {
        array_push($response, array("success" => "no"));
        array_push($response, array("message" => "invalid id"));
    } else //id found
    {
        $row = mysqli_fetch_assoc($table); //fetch one row from table 
        $HashedPassword = $row['password'];
        if (MatchPassword($HashedPassword, $old_password) == false) {
            array_push($response, array("success" => "no"));
            array_push($response, array("message" => "invalid current password"));
        } 
        else //password is matched
        {
            $new_password = HashPassword($new_password);
            $sql = "update users set password='$new_password' where id=$id";
            mysqli_query($link,$sql) or ReturnError(null,__LINE__);
            array_push($response, array("success" => "yes"));
            array_push($response, array("message" => "password changed successfully"));
        }
    }
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response);
