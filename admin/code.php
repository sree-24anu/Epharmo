<?php
include_once('connection.php');

if(isset($_POST['view_subcategory']))
{
    // $sub_category=$_POST['selected_subcategory'];
    $category = $_POST['category'];
    // echo $return=$category;

    $query = mysqli_query($conn, "SELECT cname from `categories` where status='Avaliable' and categorie='$category'");
    $return='<option selected disabled>Select</option>';

    while ($row = mysqli_fetch_assoc($query)) {
         $return .= '
         <option value="' . $row["cname"] . '">' . $row["cname"] . '</option>';
    }
    echo $return;
}

if(isset($_POST['OFD_btn']))
{
    $id=$_POST['order_id'];
    $update=mysqli_query($conn,"update `order_address` set `status`='Out for Delivery' where order_id='$id';");
    header('location:orders.php');
}

if(isset($_POST['Delivered_btn']))
{
    $id=$_POST['order_id'];
    $update=mysqli_query($conn,"update `order_address` set `status`='Delivered' where order_id='$id';");
    header('location:orders.php');

}

?>
