<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once('connection.php');

$expiryquery=mysqli_query($conn,"Select * from stocks where DATE_FORMAT(expiry,'%m')< DATE_FORMAT(CURRENT_DATE,'%m')+1;");
$row_expiry=mysqli_num_rows($expiryquery);
if($row_expiry>0)
{
    header('location:viewexpiry.php?page=stock');
}

$sqlquery=mysqli_query($conn,"Select * from stocks where qty<=0;");
$row=mysqli_num_rows($sqlquery);
if($row>0)
{
    header('location:outofstock.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href="style.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .rightpanel {
            margin: 65px 20px 20px 320px;
        }

        /* .pagnation {
            float: right;
        }
        */
        .dataTables_length label,
        .dataTables_filter label{
            display: flex;
            width: 0%;
            position: absolute;
    /* bottom: 20px; */
    /* margin-bottom: 10px; */
        }
        /* .dataTables_filter {
            right: 15px;
        } */
        .dataTables_length
        {
            margin-bottom: 5px;
            /* left: 318px; */
        }

        .form-select-sm
        {
            width: 70px !important;
            margin: 0 5px;
        }
        .dataTables_paginate
        {
            /* margin-left: 405px; */
            display: flex;
            justify-content: end;
            right: 15px;
    position: absolute;
    margin-top: 20px;
        }
        .dataTables_filter
        {
            margin-left: 210px ;
            /* display: none; */
        }
        .dataTables_info
        {
            /* margin-left: 0; */
            display: flex;
            left: 318px;
    position: absolute;
    margin-top: 20px;
        }
        .dataTables_filter input[type=search]
        {
            width: 224px;
        }

       
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.dataTables.min.css">
</head>

<body>
    <div class="panel">

        <div class="sidebar">
            <?php
              include_once('sidebar.php'); 
            ?>
        </div>

        <div class="rightpanel">
            <div class="top">
                <h1>Manage stocks</h1>
                <p><a href="addstock.php"><button class="add_btn">Add Stock</button></a></p>
            </div>

          
            <div class="table-responsive col-12 text-center">
                <table id="myTable" class=" table table-striped table-bordered border-dark" style="width: 2000px; margin-top:30px;">
                    <div class="scroll" style="color:red;">
                        <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Batch no</th>
                            <th>Category</th>
                            <th>Sub-category</th>
                            <th>Qty</th>
                            <th>Expiry</th>
                            <th>Manufacture</th>
                            <th>Package nd quantity/unit</th>
                            <th>Composition</th>
                            <th>side effects</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Action</th>


                        </tr>
                    </thead>

                    <tbody class="table-group-divider">

                        <!-- displaying the categories -->

                        <?php

                            $sno=1;
                            $sqlquery = "SELECT * FROM `stocks` ORDER BY `id` DESC";
                            $result = mysqli_query($conn, $sqlquery);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $expiry = $row['expiry']; 

                                    $date = date('m/d', strtotime($expiry));
                                echo '<tr>
                                            <td>' . $sno . '</td>
                                            <td>' . $row["genericname"] . '</td>
                                            <td>' . $row["batchno"] . '</td>
                                            <td>' . $row["category"] . '</td>
                                            <td>' . $row["sub_category"] . '</td>
                                            <td>' . $row["qty"] . ' </td>
                                            <td>' .  $date . '</td>
                                            <td>' . $row["mname"] . '</td>
                                            <td>' . $row["package"] . '</td>
                                            <td>' . $row["composition"] . '</td>
                                            <td>' . $row["side_effects"] . '</td>
                                            <td>' . $row["description"] . '</td>
                                            <td>' . $row["price"] . '</td>
                                            <td>
                                            <a href="updatestock.php?stockid=' . $row["id"] . '"><i class="bx bxs-edit bx-sm"></i></a>
                                            <a href="deletes.php?stockid=' . $row["id"] . '" onclick="return confirm(`Are you sure you want to delete it`);"><i class="bx bxs-trash-alt bx-sm"></i></a>
                                            </td>
                                        </tr>';
                                $sno++;
                            }
                        
                        ?>
                    </tbody>
                    </div>
                </table>

            </div>




        </div>
    </div>
    <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>
<script>
  $(document).ready( function () {
    $('#myTable').DataTable({
        fixedHeader: true
    });
    
  });
</script>
</body>

</html>