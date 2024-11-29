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

    <link href='style.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
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
                <h1>Manufacture Details</h1>
                <p><a href="addmanufacturer.php"><button class="add_btn">Add Manufacture</button></a></p>
            </div>
            
            <div class="table-responsive col-12 text-center">
                <table id="myTable" class=" table table-striped table-bordered border-dark">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Supplier</th>
                            <th>Email</th>
                            <th>Phone no</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="table-group-divider">

                        <!-- displaying the content -->

                       <?php
                            $sno=1;
                            $sqlquery = "SELECT * FROM `manufactures` ORDER BY id DESC";
                            $result = mysqli_query($conn, $sqlquery);

                            while ($row = mysqli_fetch_assoc($result)) {

                                echo '<tr>
                                        <td>' . $sno . '</td>
                                        <td>' . $row["mname"] . '</td>
                                        <td>' . $row["email"] . '</td>
                                        <td>' . $row["phoneno"] . '</td>
                                        <td>' . $row["address"] . '</td>
                                        <td>
                                            <a href="updatemanufacturer.php?id=' . $row["id"] . '"><i class="bx bxs-edit bx-sm"></i></a>
                                            <a href="deletes.php?mid=' . $row["id"] . '" onclick="return confirm(`Are you sure you want to delete it`);"><i class="bx bxs-trash-alt bx-sm"></i></a>
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