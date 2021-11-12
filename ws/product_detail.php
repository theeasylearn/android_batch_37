<?php 
    /*
    purpose : used to all detail of sepcific product 
    how to call : http://localhost:8080/android_batch_37/ws/product_detail.php?productid=1
    input: productid=1 
    output: 
    1) [{"error":"input is missing"}]
    2) [{"error":"no"},{"total":1},{"id":"1","categoryid":"1","title":"Acer Laptop","price":"100","stock":"98","weight":"3000","size":"15 inch","photo":"acer.jpg","detail":"WINDOWS 10 4 GB DDR3 RAM 128 gb ssd hard disk","islive":"1","isdeleted":"0"}]
    */

    require_once("../inc/connection.php");
    extract($input);
    if(isset($productid)==false)
    {
        array_push($response,array("error"=>"input is missing"));
    }
    else 
    {
        $sql = "select * from product where id=$productid and islive=1 and isdeleted=0";
        $table=mysqli_query($link,$sql) or ReturnError(null,__LINE__);
        $total = mysqli_num_rows($table);
        array_push($response,array("total"=>$total));
        if($total>=1)
        {
            $row = mysqli_fetch_assoc($table);
            array_push($response,$row);
        }
        array_unshift($response,array("error"=>"no"));
    }
    echo json_encode($response);
