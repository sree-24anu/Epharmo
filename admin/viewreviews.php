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
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link href="style.css" rel="stylesheet">
    <style>
       
      
        .dataTables_filter
        {
            display: none;
        }
        
    </style>
</head>

<body>
    <div class="contain">
        <div class="sidebar">
            <?php include_once('sidebar.php'); ?>
        </div>
        <div class="rightpanel">
            <h2>Reviews</h2>
            <div class="table-responsive">
                <table id="myTable" class=" table table-striped table-bordered border-dark text-center">
                    <thead>
                        <tr>
                            <th style="width:200px">Name</th>
                            <th style="width:200px">Date</th>
                            <th>Content</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        <?php
                        include_once('connection.php');
                        
                        $review = mysqli_query($conn, "Select * from reviews order by submit_date desc;");
                        while ($row = mysqli_fetch_assoc($review)) {
                            $submit_date = $row['submit_date']; 

                    $date = date('d-m-Y', strtotime($submit_date));
                            echo '<tr>
                        <td>' . $row['name'] . '</td>
                        <td>' . $date . '</td>
                        <td>' . $row['content'] . '</td>
                        <td style="width:100px;">  <a href="deletes.php?rid=' . $row["review_id"] . '" onclick="return confirm(`Are you sure you want to delete it`);"><i class="bx bxs-trash-alt bx-sm"></i></a>  </td>
                        </tr>';
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