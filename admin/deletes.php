<?php
    include_once('connection.php');
    if(isset($_REQUEST['cid']))
    {
        $id=$_REQUEST['cid'];
        $delete=mysqli_query($conn,"DELETE FROM `categories` WHERE `id`=$id");
        if($delete)
        {
            header('location:viewcategories.php');
        }
        else
        {
            die(mysqli_error($conn));
        }
    }
    if(isset($_REQUEST['mid']))
    {
        $id=$_REQUEST['mid'];
        $delete=mysqli_query($conn,"DELETE FROM `manufactures` WHERE `id`=$id");
        if($delete)
        {
            header('location:viewmanufacturer.php');
        }
        else
        {
            die(mysqli_error($conn));
        }
    }

    if(isset($_REQUEST['sid']))
    {
    $id=$_REQUEST['sid'];
    $delete=mysqli_query($conn,"DELETE FROM `suppliers` WHERE `id`=$id");
    if($delete)
    {
        header('location:viewsupplier.php');
    }
    else
    {
        die(mysqli_error($conn));
    }
    }

    if(isset($_REQUEST['stockid']))
    {
        $id=$_REQUEST['stockid'];
    $delete=mysqli_query($conn,"DELETE FROM `stocks` WHERE `id`=$id");
    if($delete)
    {
        header('location:viewstock.php');
    }
    else
    {
        die(mysqli_error($conn));
    }
    }

    if(isset($_REQUEST['eid']))
    {
        $id=$_REQUEST['eid'];
        $delete=mysqli_query($conn,"DELETE FROM `expiry` WHERE `id`=$id");
        if($delete)
        {
            header('location:viewexpiry.php');
        }
        else
        {
            die(mysqli_error($conn));
        }
    }

    if(isset($_REQUEST['rid']))
    {
        $id=$_REQUEST['rid'];
        $delete=mysqli_query($conn,"DELETE FROM `reviews` WHERE `review_id`=$id");
        if($delete)
        {
            header('location:viewreviews.php');
        }
        else
        {
            die(mysqli_error($conn));
        }
    }
    if(isset($_REQUEST['outofstockid']))
    {
        $id=$_REQUEST['outofstockid'];
        $delete=mysqli_query($conn,"DELETE FROM `outofstocks` WHERE `id`=$id");
        if($delete)
        {
            header('location:viewoutofstock.php');
        }
        else
        {
            die(mysqli_error($conn));
        }
    }
?>