<?php
session_start();
include_once('admin/connection.php');
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    $_SESSION['loggedin'] = false;
    $_SESSION['user_id'] = false;
    header("location: login.php");
    exit();
} else {
    $user_id = $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        *
        {
            font-family: 'Times New Roman', Times, serif;
        }
        .tbl_head {

            border-bottom: 1px solid #ccc;
        }
        .top
        {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <?php
    include_once ('admin/connection.php');
    ?>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                       <div class="top">
                       <h4 class="mb-0">Order Summary</h4>
                            <a  class="btn btn-primary" href="orderhistory.php">Back</a>
                        
                       </div>
                    </div>
                    <div class="card-body">


                        <!-- alertmsg -->
                        <div id="billing">
                            <?php
                            if (isset($_GET['order_id'])) {
                                $orderid = $_GET['order_id'];
                                if ($orderid == '') {
                                    echo ' <div class="text-center">
                                        <h5>Order_id not found</h5>
                                        <div>
                                            <a href="cart.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                                        </div>
                                    </div> ';
                                }
                                $orderquery = "SELECT * FROM order_address WHERE user_id='$user_id' AND order_id='$orderid' LIMIT 1";
                                $orderqueryres = mysqli_query($conn, $orderquery);
                                if (!$orderqueryres) {
                                    echo 'No data found ';
                                }

                                if (mysqli_num_rows($orderqueryres) > 0) {
                                    $orderdata = mysqli_fetch_assoc($orderqueryres);
                                    ?>

                                    <table style="width:100%; margin-bottom:20px;">
                                        <tbody>
                                            <tr>
                                                <td style="text-align:center;" colspan="2">
                                                    <h1 style="font-size:23px; line-height:30px; margin:2px; padding:0;">
                                                        Epharmosys</h1>
                                                    <p style="font-size:16px; line-height:24px; margin:2px; padding:0;">123,
                                                        street no 1,mangalore,India</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 style="font-size:20px; line-height:30px; margin:2px; padding:0;">
                                                        Customer details</h5>
                                                    <p style="font-size:14px; line-height:20px; margin:2px; padding:0;">Name
                                                        :<?= $orderdata['user_name'] ?> </p>
                                                    <p style="font-size:14px; line-height:20px; margin:2px; padding:0;">Phone no
                                                        :<?= $orderdata['phoneno'] ?></p>
                                                    
                                                </td>

                                                <td align="end">
                                                    <h5 style="font-size:20px; line-height:30px; margin:2px; padding:0;">Invoice
                                                        details</h5>
                                                    <p style="font-size:14px; line-height:20px; margin:2px; padding:0;">ID
                                                        :<?= $orderdata['order_id'] ?></p>
                                                    <p style="font-size:14px; line-height:20px; margin:2px; padding:0;">Date
                                                        :<?= $orderdata['order_date'] ?> </p>
                                                   
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <?php
                                }


                                ?>

                                <div class="table-responsive mb-3">
                                    <table style="width:100%;" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <th align=start class="tbl_head" width="5%">Sno</th>
                                                <th align=start class="tbl_head">Product</th>
                                                <th align=start class="tbl_head" width="10%">Price</th>
                                                <th align=start class="tbl_head" width="10%">Quantity</th>
                                                <th align=start class="tbl_head" width="10%">Total price</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $orderitem = "SELECT * FROM cart WHERE order_id='$orderid'";
                                            $orderitemres = mysqli_query($conn, $orderitem);
                                            if ($orderitemres) {
                                                if (mysqli_num_rows($orderitemres) > 0) {
                                                    while ($orderitemrows = mysqli_fetch_assoc($orderitemres)) {

                                                        ?>
                                                        <tr>
                                                            <td class="tbl_head"><?= $i++ ?></td>
                                                            <td class="tbl_head"><?= $orderitemrows['name'] ?></td>
                                                            <td class="tbl_head"><?= $orderitemrows['price'] ?></td>
                                                            <td class="tbl_head"><?= $orderitemrows['qty'] ?></td>
                                                            <td class="tbl_head">
                                                                <?= number_format($orderitemrows['price'] * $orderitemrows['qty'], 0) ?>
                                                            </td>

                                                        </tr>
                                                    <?php } ?>
                                                    <tr>

                                                        <td colspan="4" align="end" style="font-weight:bold;">Grand Total:</td>
                                                        <?php $order_total = mysqli_query($conn, "SELECT total FROM order_address WHERE order_id='$orderid';");
                                                        $order_totalrows = mysqli_fetch_assoc($order_total); ?>
                                                        <td colspan="1" style="font-weight:bold;"><?= $order_totalrows['total'] ?>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">Payment mode: Cash payment</td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>



                                        <?php
                                                } else {
                                                    echo 'No product item found';
                                                }
                                            } else {
                                                echo 'some errors';
                                            }

                            } else {
                                ?>
                                <div class="text-center">
                                    <h5>No tracking parameter
                                        found</h5>
                                    <div>
                                        <a href="cart.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>