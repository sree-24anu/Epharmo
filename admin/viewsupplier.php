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
    <link href="sty.css" rel="stylesheet">

</head>

<body>
    <div class="panel">
        <div class="sidebar">
            <?php include_once('sidebar.php'); ?>
        </div>
        <div class="rightpanel">
            <div class="top">
                <h1>Supplier Details</h1>
                <p><a href="addsupplier.php"><button>Add Suppliers</button></a></p>
            </div>
            <div class="search">
                <!-- search bar -->
                <p>
                <form action="" method="post">
                    <input type="text" name="search">
                    <input type="submit" name="searchresult" value="Search">
                </form>
                </p>
            </div>
            <br><br>
            <div class="table-responsive col-12 text-center">
                <table class=" table table-striped table-bordered border-dark">
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

                        <!-- displaying content -->

                        <?php

                        include_once('connection.php');

                        // search result
                        
                        if (isset($_POST['searchresult'])) {
                            $number = 1;
                            $search = mysqli_real_escape_string($conn, $_POST["search"]);
                            $sqlsearch = "SELECT * FROM `suppliers` WHERE sname='$search'";
                            $res = mysqli_query($conn, $sqlsearch);
                            $num = mysqli_num_rows($res);
                            if ($num > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo '<tr>
                                            <td>' . $number . '</td>
                                            <td>' . $row["sname"] . '</td>
                                            <td>' . $row["email"] . '</td>
                                            <td>' . $row["phoneno"] . '</td>
                                            <td>' . $row["address"] . '</td>
                                            <td>
                                                <a href="updatesupplier.php?id=' . $row["id"] . '"><i class="bx bxs-edit bx-sm"></i></a>
                                                <a href="deletes.php?sid=' . $row["id"] . '" onclick="return confirm(`Are you sure you want to delete it`);"><i class="bx bxs-trash-alt bx-sm"></i></a>
                                            </td>
                                        </tr>';
                                    $number++;
                                }
                            } else {
                                echo '<tr> <td colspan="6"> No search result found </td> </tr>';
                            }
                        } else {
        
                            $limit = 10;
                            $pg_name="viewsupplier.php";
                            if (isset($_GET["pages"])) {
                                $offset = ($_GET["pages"] - 1) * $limit;
                                $page = ($_GET["pages"] - 1);

                            } else {
                                $offset = 0;
                                $page = 0;
                            }


                            $pgnt=false;
                            $query = "SELECT * FROM `suppliers`";
                            $result = mysqli_query($conn, $query);
                            $totalrows = mysqli_num_rows($result);
                            if($totalrows>=1)
                            {
                                $pgnt=true;
                            }
                            if ($totalrows > $limit) {
                                $totalpages = ceil($totalrows / $limit);
                            } else {
                                $totalpages = 0;
                            }

                            $serialno = $page * $limit + 1;


                            $sqlquery = "SELECT * FROM `suppliers` limit $limit offset $offset";
                            $result = mysqli_query($conn, $sqlquery);

                            while ($row = mysqli_fetch_assoc($result)) {


                            
                                echo '<tr>
                                        <td>' . $serialno . '</td>
                                        <td>' . $row["sname"] . '</td>
                                        <td>' . $row["email"] . '</td>
                                        <td>' . $row["phoneno"] . '</td>
                                        <td>' . $row["address"] . '</td>
                                        <td>
                                            <a href="updatesupplier.php?id=' . $row["id"] . '&currentpg=' . $page . '"><i class="bx bxs-edit bx-sm"></i></a>
                                            <a href="deletes.php?sid=' . $row["id"] . '&currentpg=' . $page . '" onclick="return confirm(`Are you sure you want to delete it`);"><i class="bx bxs-trash-alt bx-sm"></i></a>
                                        </td>
                                    </tr>';
                                $serialno++;
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <!-- pagnation -->

            <div class="pagnation">

                <?php
                if (!isset($_POST['searchresult'])) {
                    if($pgnt)
                    {
                $i=$offset+$limit;
                if($i<$totalrows)
                {
                    $last_entry=$i;
                    $i=$i+$limit;
                }
                else
                {
                    $last_entry=$totalrows;
                }


                echo '<p>Showing '.$offset+1 .' to '. $last_entry .' of '. $totalrows .' entries </p>';
                include_once('pagnation.php'); 
                }
            }
                else
                {
                echo '<a href="viewsupplier.php" class="btn btn-primary" style="position: absolute; right:20px;">View all</a>';
                }
                ?>
            </div>

        </div>
    </div>
</body>

</html>