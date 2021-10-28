<?php 
    /*
    purpose : used to get checkout by specific user
    how to call : http://localhost:8080/android_batch_37/ws/checkout.php?usersid=1&fullname=ankit_patel&address1=eva_surbhi&address2=waghawadi_road&city=bhanvnagar&mobile=1234567890&pincode=364001&remarks=delivery_after_6_pm
    input: usersid,fullname,address1,address2,city,mobile,pincode,remarks
    output: 
    1) [{"error":"input is missing"}]
    */
    require_once("../inc/connection.php");
    extract($input);
    if(isset($usersid,$fullname,$address1,$address2,$city,$mobile,$pincode,$remarks)==false)
    {
        array_push($response,array("error"=>"input missing"));
    }
    else 
    {
        /*
            
        */
        array_unshift($response,array("error"=>"no"));    
    }
    echo json_encode($response);
?>
