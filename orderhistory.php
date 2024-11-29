<?php
session_start();
include_once ('admin/connection.php');
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
    <style>
        .orders {
            background-color: #ececec;
            border-radius: 20px;
            margin: 20px;
        }

        .itm_details {
            display: none;
        }

        .itm_details a {
            text-decoration: none;
            color: black;
        }

        .row_display,
        .img {
            display: flex;
            margin: 10px;
        }

        .order_display {
            display: block;
            width: 200px;
        }

        .font-size {
            font-size: large;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="navbar">
        <?php
        include_once ('navbar.php');
        ?>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center border rounded my-5">
                <h1>Your Orders</h1>

            </div>

            <?php
            include_once ('admin/connection.php');
            $sql = "select * from order_address where `user_id`='$user_id' order by order_date desc;";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) >= 1) {


                echo ' <div class="col-lg-7 text-center">';


                while ($row = mysqli_fetch_assoc($res)) {
                    $order_date = $row['order_date'];

                    $date = date('d-m-Y', strtotime($order_date));
                    echo '<div class="orders">
        <div class="row_display">
            <h4><lable class="font-size order_display">Order-date:</lable></h4>
            <h4 class="w-100 font-size">' . $date . '</h4>
        </div>
        <div class="row_display">
            <h4><lable class="font-size order_display">Order-id:</lable></h4>
            <h4 class="w-100 font-size">' . $row['order_id'] . '</h4>
        </div>
        <div class="row_display">
            <h4><lable class="font-size order_display">Price:</lable></h4>
            <h4 class="w-100 font-size">Rs. ' . $row['total'] . '</h4>
        </div>
        
        <div class="row_display">
            <h4><lable class="font-size order_display">Status:</lable></h4>
            <h4 class="w-100 font-size">' . $row['status'] . '</h4>
        </div>
        <div class="row_display">
            <h4><lable class="font-size order_display">Invoice:</lable></h4>
            <h4 class="w-100 font-size"><a class="btn btn-primary" href="view-order-summary.php?order_id=' . $row['order_id'] . '">View</a>
        </div>

        
        <button value="' . $row['order_id'] . '" class="btn btn-primary w-50">View details</button>
        </div>
    
        <div class="itm_details" id="' . $row['order_id'] . '">';


                    $orders_history = mysqli_query($conn, "select * from cart where order_id='$row[order_id]';");
                    while ($row2 = mysqli_fetch_assoc($orders_history)) {
                        $id = $row2['prod_id'];
                        
                        echo '
          <div class="img">
            <img src="images/' . $row2['image'] . '" alt="' . $row2['name'] . '" style="width:100px; border:1px solid black; margin-left:50px">
            <div class="w-100">
            <p>ITEM:' . $row2['name'] . '</p>
            <p>QUANTITY:' . $row2['qty'] . '</p>
            <p>PRICE:Rs. ' . $row2['price'] . '</p>

            </div>
            </div>
            ';
                    }
                    ?>
                </div>


            <?php }


                echo '</div> ';
                ?>

            <div class="col-lg-5">



                <h2>Know Your Order Status</h2>
                <span>Please enter your Order ID to know your order status.</span>
                <div class="form text-center">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                        <div class="form-group row_display">
                            <label>Order ID</label>
                            <input type="text" class="form-control" name="orderid" required>
                        </div>
                        <button type="submit" name="status_btn" class="btn btn-primary">Check</button>
                    </form>
                </div>

                <?php
                if (isset($_POST['status_btn'])) {
                    $oid = $_POST['orderid'];
                    if($oid != '')
                    {
                        $status = mysqli_query($conn, "SELECT * FROM order_address WHERE order_id='$oid'");
                        $row = mysqli_fetch_array($status);
                        if(mysqli_num_rows($status)>=1)
                        {
                            $items = mysqli_query($conn, "SELECT * FROM cart WHERE order_id='$oid'");
                            $items_row = mysqli_num_rows($items);
                            
                            $order_date = $row['order_date'];

                            $date = date('Y-m-d', strtotime($order_date));

                            echo '<div class="orders">
                                    <div class="row_display">
                                        <h4><lable class="font-size order_display">Order-date:</lable></h4>
                                        <h4 class="font-size w-100">' . $date . '</h4>
                                    </div>
                                    <div class="row_display">
                                        <h4><lable class="font-size order_display">Items:</lable></h4>
                                        <h4 class="font-size w-100">' . $items_row . '</h4>
                                    </div>
                                    <div class="row_display">
                                        <h4><lable class="font-size order_display">Amount:</lable></h4>
                                        <h4 class="font-size w-100">Rs. ' . $row['total'] . '</h4>
                                    </div>
                                    <div class="row_display">
                                        <h4><lable class="font-size order_display">Status:</lable></h4>
                                        <h4 class="font-size w-100">' . $row['status'] . '</h4>
                                    </div>
                                </div>';
                        }
                        else
                        {
                            echo '<br><h5 class="text-center">No data found</h5>';
                        }
                    }
                    else
                    {
                        echo '<br><h5 class="text-center">Enter the order id</h5>';
                    }
                }

            } else {
                echo '<h4 class="text-center">You have not ordered any products</h4>';
            }
            ?>

            <!-- </div> -->

        </div>
    </div>




    </div>
    <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function () {
            $('.btn').click(function (e) {



                var btn = "#" + $(this).attr('value');
                // console.log(btn);



                $(btn).toggle();

            });


        });
    </script>
</body>

</html>