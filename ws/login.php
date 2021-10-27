<?php
/*
    purpose : used to login as buyer in application 
    how to call : http://localhost:8080/android_batch_37/ws/login.php?email=ankit3385@gmail.com&password=123123
    input: email,password (compulsory)
    output: 
      in case input is missing
     [{"error":"input is missing"}]
     in case of invalid email or password 
     [{"error":"no"},{"success":"no"},{"message":"invalid login attempt"}]
     in case of succesfull login 
     [{"error":"no"},{"success":"yes"},{"message":"login successfull"},{"id":"1"}]
*/
require_once("../inc/connection.php");
extract($input);
if (isset($email, $password) == false) {
    array_push($response, array("error" => "input is missing"));
} else {

    $sql = "select id,password from users where email='$email'";
    $table = mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    $total = mysqli_num_rows($table);
    if ($total == 0) //email not found
    {
        array_push($response, array("success" => "no"));
        array_push($response, array("message" => "invalid login attempt"));
    } else //email found
    {
        $row = mysqli_fetch_assoc($table); //fetch one row from table 
        $HashedPassword = $row['password'];
        if (MatchPassword($HashedPassword, $password) == false) {
            array_push($response, array("success" => "no"));
            array_push($response, array("message" => "invalid login attempt"));
        } 
        else //password is also matched
        {
            array_push($response, array("success" => "yes"));
            array_push($response, array("message" => "login successfully"));
            array_push($response, array("id" =>$row['id']));
        }
    }
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response);
