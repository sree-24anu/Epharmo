<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
  header("location: login.php");
  exit();
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Epharmosys</title>
  <link href="style.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
</head>

<body>
  <div class="dash">
    <?php include_once ('connection.php'); ?>

    <div class="contain">
      <!-- sidebar -->

      <div class="sidebar">
        <?php include_once ('sidebar.php'); ?>
      </div>

      
        <div class="dashboard">
          <div class="title">
            <h1>Dashboard</h1>
          </div>
          <div class="container overflow-hidden text-center">
            <div class="row g-5 row-cols-1 row-cols-lg-2">
              <div class="col col-md-8 col-lg-7">
                <div class="row g-3 row-cols-md-2 row-cols-lg-2 ">

                  <?php
                  $customer = mysqli_query($conn, 'select * from user_login') or die('query failed');
                  $customercount = mysqli_num_rows($customer);
                  $medicine = mysqli_query($conn, 'select * from stocks') or die('query failed');
                  $medicinecount = mysqli_num_rows($medicine);
                  $expiredmedicine = mysqli_query($conn, 'select * from expiry') or die('query failed');
                  $expiredmedicinecount = mysqli_num_rows($expiredmedicine);
                  $stock = mysqli_query($conn, 'select * from outofstocks') or die('query failed');
                  $stockcount = mysqli_num_rows($stock);
                  ?>

                  <div class="col ">
                    <div class="p-3 box-info ">
                      <img src="../usage/images/customer1.jpg" alt="customers">
                      <div class="text">
                        <?php echo '<h3>' . $customercount . '</h3>'; ?>
                        <h5>Total customers</h5>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <div class="p-3 box-info">
                      <img src="../usage/images/medicine.jpg" alt="medicine">
                      <div class="text">
                        <?php echo '<h3>' . $medicinecount . '</h3>'; ?>
                        <h5>Total medicine</h5>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <div class="p-3 box-info">
                      <img src="../usage/images/expiredmedicine1.jpg" alt="expired medicine">
                      <div class="text">
                        <?php echo '<h3>' . $expiredmedicinecount . '</h3>'; ?>
                        <h5>Expired medicine</h5>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <div class="p-3 box-info">
                      <img src="../usage/images/outofstock.jpg" alt="out of stock">
                      <div class="text">
                        <?php echo '<h3>' . $stockcount . '</h3>'; ?>
                        <h5>Out of stock</h5>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col col-md-4 col-lg-5">
                <table class=" table table-striped table-bordered border-dark">
                  <thead>
                    <tr>
                      <th colspan="2">Report</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <?php
                      $daily_total = 0;
                      $dtotal = mysqli_query($conn, "SELECT SUM(total) AS dtotal FROM order_address WHERE DATE(order_date) = CURDATE();");
                      $dtotal_row = mysqli_fetch_assoc($dtotal);
                      $daily_total = $daily_total + $dtotal_row['dtotal'];
                      echo '<th>Total sales</th>
                      <td>Rs. ' . $daily_total . '</td>';
                      ?>
                    </tr>

                    <tr>
                      <?php
                      $monthly_total = 0;
                      $mtotal = mysqli_query($conn, "SELECT sum(total) as mtotal  from order_address 
                                                  where date_format(order_date,'%m')=date_format(CURRENT_DATE,'%m');");
                      $mtotal_row = mysqli_fetch_assoc($mtotal);
                      $monthly_total = $monthly_total + $mtotal_row['mtotal'];
                      echo '<th>Monthly sales ( ' . date('M') . ')</th>
                      <td>Rs. ' . $monthly_total . '</td>';
                      ?>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

      
    </div>

</body>

</html>