<?php
    include_once('connection.php');
    $id=$_REQUEST['id'];
    $delete=mysqli_query($conn,"DELETE FROM `store_customers` WHERE `cid`=$id");
    if($delete)
    {
        header('location:customer-list.php');
    }
?>