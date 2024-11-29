<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once('connection.php');
$query = "SELECT * FROM `categories`";
$res = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($res)) {
    $category = $row['cname'];
    $qur = "Select `qty` from `stocks` where `category`='$category'";
    $res = mysqli_query($conn, $qur);
    $row = mysqli_num_rows($res);
    if ($row >= 1) {

        $sqlquery=mysqli_query($conn,"Select * from stocks where qty=0;");
        $row=mysqli_num_rows($sqlquery);
        if($row>0)
        {
            // echo "there is qtantity 0";
             header("location:outofstock.php?page=category");
        }
        // else{
        //     echo "no quantity 0";
        // }
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
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
                <h1>Category</h1>
                <p><a href="addcategories.php"><button class="add_btn">Add Categories</button></a></p>
            </div>

            
            <div class="table-responsive col-12 text-center">
                <table id="myTable" class=" table table-striped table-bordered border-dark">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Categorie</th>
                            <th>Sub-categorie</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="table-group-divider">

                        <!-- displaying the categories -->

                        <?php

                            $sno=1;
                            $sqlquery = "SELECT * FROM `categories` ORDER BY id DESC";
                            $result = mysqli_query($conn, $sqlquery);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                            <td>' . $sno . '</td>
                                            <td>' . $row["categorie"] . '</td>
                                            <td>' . $row["cname"] . '</td>
                                            <td>' . $row["status"] . '</td>
                                            <td>  
                                            <a href="updatecategories.php?id=' . $row["id"] . '"><i class="bx bxs-edit bx-sm"></i></a>
                                            <a href="deletes.php?cid=' . $row["id"] . '" onclick="return confirm(`Are you sure you want to delete it`);"><i class="bx bxs-trash-alt bx-sm"></i></a>
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
    $('#myTable thead th[colspan]').wrapInner( '<span/>' ).append( '&nbsp;' );

  });
</script>

</body>

</html>