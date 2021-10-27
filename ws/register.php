<?php 
    /*
    purpose : used to register as buyer in application 
    how to call : http://localhost:8080/android_batch_37/ws/register.php?email=ankit3385@gmail.com&password=123123&mobile=1234567890
    input: email,password,mobile (compulsory)
    output: 
      in case input is missing
     [{"error":"input is missing"}]

     registeration failed 
    [{"error":"no"},{"success":"no"},{"message":"email or mobile is already register with us"}]
    
    registeration sucessfull 
    [{"error":"no"},{"success":"yes"},{"message":"registered successfully"}]
*/
    require_once("../inc/connection.php");
    extract($input);
    if(isset($email,$password,$mobile)==false)
    {
        array_push($response,array("error"=>"input is missing"));
    }
    else 
    {

        $sql = "select count(*) 'total_record' from users where email='$email' or mobile='$mobile'";
        $table= mysqli_query($link,$sql) or ReturnError(null,__LINE__);
        $row = mysqli_fetch_assoc($table);
        if($row['total_record']>=1) //email or mobile found in users table 
        {
            array_push($response,array("success"=>"no"));
            array_push($response,array("message"=>"email or mobile is already register with us"));
        }
        else //no row found in users table as per query (continue with registration )
        {
            $password = HashPassword($password);
            $sql = "insert into users (email,password,mobile) values('$email','$password','$mobile')";
            mysqli_query($link,$sql) or ReturnError(null,__LINE__);
            array_push($response,array("success"=>"yes"));
            array_push($response,array("message"=>"registered successfully"));
        }
        array_unshift($response,array("error"=>"no"));
    }
    echo json_encode($response);
