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
</head>

<body>
    <div class="contain">
        <div class="sidebar">
            <?php include_once('sidebar.php'); ?>
        </div>
        <div class="rightpanel">
            <h2>Customers</h2>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered border-dark text-center">
                    <thead>
                        <tr>
                        <th>Sno</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        <?php
                        
                        include_once('connection.php');
                        $sno=1;

                        $sqlquery = "SELECT * FROM `user_login` ORDER BY `id` DESC";
                        $result = mysqli_query($conn, $sqlquery);

                        while ($row = mysqli_fetch_assoc($result)) {

                            echo '<tr>
                        <td>'.$sno.'</td>
                        <td>' . $row['name'] . '</td>
                        <td>' . $row['username'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td>' . $row['contactno'] . '</td>

                        
                        </tr>';
                        $sno++;
                        }
                        ?>

                        </tr>
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