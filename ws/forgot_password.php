<?php
/*
    purpose : used to recover password in case of user forgot password
    how to call : http://localhost:8080/android_batch_37/ws/forgot_password.php?email=theeasylearn@gmail.com
    input:email(compulsory)
    output: 
      in case input is missing
     [{"error":"input is missing"}]
    
*/
require_once("../inc/connection.php");
require_once("../inc/function.php");
extract($input);
if (isset($email) == false) {
    array_push($response, array("error" => "input is missing"));
} else { //all inputs are given

    $sql = "select count(*) 'total_record' from users where email='$email'";
    $table = mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    $row = mysqli_fetch_assoc($table); //fetch one row from table 
    if ($row['total_record'] == 0) //EMAIL no found
    {
        array_push($response, array("success" => "no"));
        array_push($response, array("message" => "email not found"));
    } else //email found
    {
            //generate new password 
            $new_password = rand(10,99) . rand(10,99) . rand(10,99) . rand(10,99);
            $HashedPassword =  HashPassword($new_password);
            $sql = "update users set password='$HashedPassword' where email='$email'";
            $subject = "Congratulation we have recovered your account";
            $content = "Dear $email <br/> your new password is $new_password <br/> change your password after login. <br/> Thanks";
            SendMail($email,$subject,$content);
            mysqli_query($link,$sql) or ReturnError(null,__LINE__);
            array_push($response, array("success" => "yes"));
            array_push($response, array("message" => "we have sent you password recover detail on your registered email address"));
    }
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response);
