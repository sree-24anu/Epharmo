<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once ('connection.php');

// lessen the stocks

$query=mysqli_query($conn,"select name,order_id,prod_id,qty,status from cart;");
while($row=mysqli_fetch_assoc($query))
{
    if($row['status'] != 'Processed')
    {
        // echo $row['order_id'];
        $qty=mysqli_query($conn,"select genericname,qty from stocks where id='$row[prod_id]';");
        $qty_row=mysqli_fetch_assoc($qty);
        $qty= $qty_row['qty'] - $row['qty'];

        
        $update=mysqli_query($conn,"Update stocks set qty='$qty' where id='$row[prod_id]';");
        if($update)
        {
            $update2=mysqli_query($conn,"Update cart set status='Processed' where prod_id='$row[prod_id]';");
            if($update2)
            {
                $update2=mysqli_query($conn,"Update order_address set status='Processed' where order_id='$row[order_id]';");
            }
        }
         
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="panel">

        <div class="sidebar">
            <?php
            include_once ('sidebar.php');
            ?>
        </div>

        <div class="rightpanel">

            <div class="top">
                <h1>Orders</h1>
            </div>

          

            <div class="table-responsive text-center ">
                <table id="myTable" class=" table table-bordered border-dark">
                    <thead>
                        <tr>
                            <th>Order id</th>
                            <th>Customer name</th>
                            <th>Phone no</th>
                            <th>Address</th>
                            <th>Orders</th>
                            <th>Payment mode</th>
                            <th>order_date</th>
                            <th>Status</th>
                            <th>Change status</th>

                        </tr>
                    </thead>
                    <tbody class="table-group-divider">


                        <?php
                        include_once ('connection.php');

                        $sqlquery = "SELECT * FROM `order_address` ORDER BY `order_date` DESC";
                        
                        $result = mysqli_query($conn, $sqlquery);
                        if (!$result) {
                            die("Error executing query: " . mysqli_error($conn));
                        }
                        
                       
                        $num = 1;
                       
                        while ($row = mysqli_fetch_assoc($result)) {
                            // var_dump($row); 

                            $order_date = $row['order_date'];

                            $date = date('d-m-Y', strtotime($order_date));

                            echo '<tr>
                        <td>' . $row['order_id'] . '</td>
                        <td> ' . $row['user_name'] . ' </td>
                        <td> ' . $row['phoneno'] . ' </td>
                        <td> ' . $row['address'] . ' </td>

                        <td>
                            <button class="btn view_orders_btn btn-primary" id="' . $row['order_id'] . '">View</button>
                            <div class="hide ' . $row['order_id'] . '">
                                <table class="table-bordered border-dark w-100">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>';


                            $sql2 = mysqli_query($conn, "select * from `cart` where order_id='$row[order_id]';");
                            while ($row2 = mysqli_fetch_assoc($sql2)) {
                                echo '<tr>
                                             <td>' . $row2['name'] . '</td>
                                            <td>' . $row2['qty'] . '</td>
                                            <td>' . $row2['price'] . '</td>
                                        </tr>';
                            }
                            echo '
                                        <tr>
                                        <td colspan="3">Gtotal: ' . $row['total'] . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>COD</td>

                       

                        <td> ' . $date . ' </td>
                        <td> ' . $row['status'] . ' </td>

                        <td style="width:180px"> 
                        <form action="code.php" method="post">
                            <input type="hidden" name="order_id" value="' . $row['order_id'] . '"> 
                            <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom: 2px;" name="OFD_btn">Out for delivery</button>
                        </form>
                        <form action="code.php" method="post">
                            <input type="hidden" name="order_id" value="' . $row['order_id'] . '"> 
                            <button type="submit" class="btn btn-primary btn-sm" name="Delivered_btn">Delivered</button>
                        </form>
                        </td>

                        
                        </tr>';
                        $num++;

                        }
                        ?>
                    </tbody>
                </table>

            </div>


        </div>

    </div>



    <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.view_orders_btn').click(function (e) {
                // console.log(9);
                var buttons = "." + $(this).attr('id');
                console.log(buttons);
                $(buttons).toggle();
            });
            $('#myTable').DataTable({
                order: [[8, 'desc']]
            });

  });
    


    </script>



</body>

</html>