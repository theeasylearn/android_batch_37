<?php
/*
    purpose : used to get checkout by specific user
    how to call : http://localhost:8080/android_batch_37/ws/checkout.php?usersid=1&fullname=ankit_patel&address1=eva_surbhi&address2=waghawadi_road&city=bhanvnagar&mobile=1234567890&pincode=364001&remarks=delivery_after_6_pm
    input: usersid,fullname,address1,address2,city,mobile,pincode,remarks
    output: 
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"success":"no"},{"message":"cart is empty"}]
    3) [{"error":"no"},{"success":"no"},{"message":"following products are out of stock, please remove it from cart to proceed \n Acer Laptop\n dell laptop\n "}]
    4) [{"error":"no"},{"success":"yes"},{"message":"your order placed successfully with orderid = 2"}]
    */
require_once("../inc/connection.php");
extract($input);
if (isset($usersid, $fullname, $address1, $address2, $city, $mobile, $pincode, $remarks) == false) {
    array_push($response, array("error" => "input missing"));
} else {

    // fetch products added into cart
    $sql = "select c.id 'cartid',quantity,productid,title,p.price,stock from cart c,product p where productid=p.id and billid=0 and usersid=$usersid";
    $table = mysqli_query($link, $sql) or ReturnError(null, __LINE__);
    $data = array(); //blank array
    while ($row = mysqli_fetch_assoc($table)) {
        $data[] = $row; //it is equal to array_push($data,$row)
    }
    $datasize = sizeof($data);
    if ($datasize == 0) //no product added into cart
    {
        array_push($response, array("success" => "no"));
        array_push($response, array("message" => "cart is empty"));
    } else {
        //check each and every item in cart is in stock or not 
        $i = 0;
        $outofstock = array();
        while ($i < $datasize) {
            if ($data[$i]['quantity'] > $data[$i]['stock']) {
                $outofstock[] = $data[$i];
            }
            $i++; //2
        }
        $outofstocksize = sizeof($outofstock);
        //echo $outofstocksize;
        if ($outofstocksize >= 1) {
            array_push($response, array("success" => "no"));
            $j = 0;
            $temp = null;
            while ($j <= $outofstocksize) {
                $temp = $temp . "\n " . $outofstock[$j]['title'];
                $j++;
            }
            array_push($response, array("message" => "following products are out of stock, please remove it from cart to proceed $temp"));
        } else //all products added into cart is in stock
        {
            //now update stock in product 
            $i = 0;
            $GrandTotal=0;
            while ($i < $datasize) 
            {
                $sql = "update product set stock=stock-{$data[$i]['quantity']} where id={$data[$i]['productid']}";
                mysqli_query($link, $sql) or ReturnError(null, __LINE__);
                $GrandTotal = $GrandTotal + $data[$i]['quantity'] * $data[$i]['price'];
                $i++;
            }
            //echo $GrandTotal;
            $billdate = date("Y-m-d");
            $sql = "INSERT INTO bill(usersid, billdate, fullname, address1, address2, mobile, city, pincode, paymentmode, paymentstatus, orderstatus, amount, remarks) VALUES ($usersid,'$billdate','$fullname','$address1','$address2','$mobile','$city','$pincode',1,2,1,$GrandTotal,'$remarks')";
            mysqli_query($link, $sql) or ReturnError(null, __LINE__);
            $billid = mysqli_insert_id($link); //return id of newly added record
            $i = 0;
            while ($i < $datasize) 
            {
                $sql = "update cart set price={$data[$i]['price']},billid=$billid where id={$data[$i]['cartid']}";
                mysqli_query($link, $sql) or ReturnError(null, __LINE__);
                $i++;
            }
            array_push($response, array("success" => "yes"));
            array_push($response, array("message" => "your order placed successfully with orderid = $billid"));
        }
    }
    array_unshift($response, array("error" => "no"));
}
echo json_encode($response); //done
