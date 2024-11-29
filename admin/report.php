<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link href="style.css" rel="stylesheet">
    <style>
       

        .dataTables_filter {
            display: none;
        }
    </style>
</head>

<body>
    <div class="contain">
        <div class="sidebar">
            <?php include_once ('sidebar.php'); ?>
        </div>
        <div class="rightpanel">
            <h2>Report</h2>

            <div class="container w-50 tbl-flow">
                <table class="table table-striped table-bordered border-dark ">


                    <tbody>

                        <tr>
                            <?php
                            include_once ('connection.php');

                            $no_of_users = mysqli_query($conn, "select * from `user_login`;");
                            $user_count = mysqli_num_rows($no_of_users);

                            ?>
                            <th>Total Online Customer</th>
                            <td>
                                <?php echo $user_count; ?>
                            </td>
                        </tr>
                        <?php
                        $s = 1;
                        $grand_total = mysqli_query($conn, "SELECT SUM(total) AS grandtotal,DATE_FORMAT(order_date, '%M') AS month
                                FROM order_address
                                GROUP BY DATE_FORMAT(order_date, '%Y-%m') order by DATE_FORMAT(order_date, '%m') DESC ;");
                        while ($total_row = mysqli_fetch_assoc($grand_total)) {
                            echo '<tr>
                                <th class="w-50">' . $total_row['month'] . ' total</th>
                                <td> ' . $total_row['grandtotal'] . ' </td>
                            </tr>';
                            $s++;
                        }
                        ?>

                    </tbody>
                </table>

            </div>

            <br>

            <div class="filter">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                    echo $_GET['from_date'];
                                } ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                    echo $_GET['to_date'];
                                } ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="margin-top:22px;">
                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                <button type="button" class="btn btn-primary btn-sm"
                                    onclick="clearFilters()">Reset</button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>



            <br>
            <div class="table-responsive">
                <table id="myTable" class="text-center table table-striped table-bordered border-dark">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Number of orders</th>
                            <th>Amount</th>

                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        <?php
                        include_once ('connection.php');



                        if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                            $from_date = $_GET['from_date'];
                            $to_date = $_GET['to_date'];

                            if ($from_date <= $to_date) {

                                $date_day = mysqli_query($conn, "SELECT DATE_FORMAT(order_date, '%d %b, %Y') AS order_date, 
                                                                DAYNAME(order_date) AS day_name, SUM(total) as gtotal 
                                                            FROM order_address 
                                                            WHERE order_date BETWEEN '$from_date ' AND '$to_date' 
                                                            GROUP BY DATE(order_date) ORDER BY order_date DESC;");
                                if (mysqli_num_rows($date_day) > 0) {
                                    while ($row = mysqli_fetch_assoc($date_day)) {
                                        echo '<tr>
                                        <td>
                                        <div class="date_day"><b>' . $row['day_name'] . '</b> &nbsp;&nbsp; <p>' . $row['order_date'] . '</p></div>
                                        </td>';

                                        $sql_report = mysqli_query($conn, "SELECT `order_id` 
                                                                        FROM `order_address` 
                                                                        WHERE DATE(`order_date`) = STR_TO_DATE('$row[order_date]', '%d %b, %Y');");
                                        $count = mysqli_num_rows($sql_report);

                                        echo ' <td>' . $count . '</td>
                                        <td>' . $row['gtotal'] . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr>
                                            <td></td>
                                            <td>No records found</td>
                                            <td></td>
                                            </tr>';
                                }
                            } else {
                                echo '<tr><td>Enter correct date range!!`From date` is greater than `To` date</td><td></td><td></td></tr>';
                            }
                        } else {
                            $date_day = mysqli_query($conn, "SELECT DATE_FORMAT(order_date, '%d %b, %Y') as order_date, 
                                                            DAYNAME(order_date) as day_name, SUM(total) as gtotal 
                                                            FROM order_address 
                                                            GROUP BY DATE(order_date) ORDER BY order_date DESC;");
                            while ($row = mysqli_fetch_assoc($date_day)) {
                                echo '<tr>
                        <td><div class="date_day"><b>' . $row['day_name'] . '</b> &nbsp;&nbsp; <p>' . $row['order_date'] . '</p></div></td>';
                                $sql_report = mysqli_query($conn, "SELECT `order_id` 
                            FROM `order_address` 
                            WHERE DATE(`order_date`) = STR_TO_DATE('$row[order_date]', '%d %b, %Y');");
                                $count = mysqli_num_rows($sql_report);
                                echo '<td>' . $count . '</td>
                        <td>' . $row['gtotal'] . '</td>
                        
                        </tr>';
                            }
                        }

                        ?>



                        </tr>
                    </tbody>
                </table>
            </div>

            <br>


        </div>
    </div>
    <script>
        function clearFilters() {
            // Clear the GET parameters from the URL
            window.location.href = window.location.pathname;
        }
    </script>

    <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
            $('#myTable thead th[colspan]').wrapInner('<span/>').append('&nbsp;');

        });
    </script>
</body>

</html>