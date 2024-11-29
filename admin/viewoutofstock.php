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
    <link href="style.css" rel="stylesheet">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->  
</head>
<body>
<div class="panel">
        <div class="sidebar">
            <?php 
              include_once('sidebar.php');
              include_once('connection.php'); 
            ?>
        </div>

        <div class="rightpanel">
            <div class="top">
                <h1>Out of stock</h1>
            </div>


            <div class="table-responsive col-12 text-center">
                <table id="myTable" class=" table table-striped table-bordered border-dark">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Sub-category</th>
                            <th>Price</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody class="table-group-divider">

                        <!-- displaying the categories -->

                        <?php

                            $sno=1;
                            $sqlquery = "SELECT * FROM `outofstocks`";
                            $result = mysqli_query($conn, $sqlquery);
                            $num_rows = mysqli_num_rows($result);
                            while ($row = mysqli_fetch_assoc($result)) {
                                  echo '<tr>
                                            <td>' . $sno . '</td>
                                            <td>' . $row["name"] . '</td>
                                            <td>' . $row["category"] . '</td>
                                            <td>' . $row["subcategory"] . '</td>
                                            <td>' . $row["price"] . '</td>
                                            <td>
                                            <a href="deletes.php?outofstockid=' . $row["id"] . '" onclick="return confirm(`Are you sure you want to delete it`);"><i class="bx bxs-trash-alt bx-sm"></i></a>
                                            </td>
                                        </tr>';
                                $sno++;
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
  $(document).ready( function () {
    $('#myTable').DataTable();

  });
</script>

</body>
</html>