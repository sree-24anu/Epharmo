<?php
session_start();
include_once ('admin/connection.php');
$msg = false;
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    $_SESSION['loggedin'] = false;
    $_SESSION['user_id'] = false;
    $msg = false;
} else {
    $msg = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
        }

        .img {
            height: 300px;
            margin: auto;
            justify-content: center;
            display: grid;
        }

        .img img {
            width: 350px;
            height: 260px;
        }

        .items {
            border: 0;
            margin-top: 117px
        }
    </style>
</head>

<body>
    <div class="navbar">
        <?php
        include_once ('navbar.php');
        ?>
    </div>
    <div class="container" style="margin-top:60px" ;>
        <div class="row">
            <div class="col-lg-7">



                <?php
                include_once ('admin/connection.php');
                $id = $_REQUEST['id'];
                // echo $id;
                $page = $_REQUEST['page'];
                $sql = mysqli_query($conn, "Select * from stocks where id='$id';");
                while ($row = mysqli_fetch_assoc($sql)) {
                    $expiry = $row['expiry'];

                    $date = date('m/d', strtotime($expiry));
                    echo '<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="' . $page . '.php">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">' . $row['genericname'] . '</li>
        </ol>
    </nav>
        <div class="img">
        <img src="images/' . $row['image'] . '" alt="">
    </div>
    <div class="content">
        <h3>' . $row['genericname'] . '</h3>
        <h4>Description:</h4><br>
        <p>' . $row['description'] . '</p>
        <h4' . $row['package'] . '</h4>

        <table class="table table-bordered border-dark">
                    

                    <tbody>
                        <tr>
                            <th class="w-50">COMPOSITION</th>
                            <td>' . $row['composition'] . '</td>
                        </tr>

                        <tr>
                            <th class="w-50">SIDE EFFECTS</th>
                            <td>' . $row['side_effects'] . '</td>
                        </tr>

                        <tr>
                            <th>MANUFACTURE</th>
                            <td>' . $row['mname'] . '</td>
                        </tr>

                        <tr>
                            <th>EXPIRY</th>
                            <td>' . $date . '</td>
                        </tr>

                        <tr>
                            <th>PRICE</th>
                            <td>' . $row['price'] . '</td>
                        </tr>
                    </tbody>
                </table>
        
                <form action="insertintocart.php" method="POST">
                <input type="hidden" name="name" value="' . $row['genericname'] . '">
                  <input type="hidden" name="price" value="' . $row['price'] . '">
                  <input type="hidden" name="img" value="' . $row['image'] . '">
                  <input type="hidden" name="pro_id" value="' . $id . '">
                  <input type="hidden" name="page_return" value="' . $row['category'] . '"> ';

                  if ($msg) {
                    if (isset($_SESSION['cart'])) {
                        $myitems = array_column($_SESSION['cart'], 'Itemname');
                        if (in_array($row['genericname'], $myitems)) {
                            echo '<button type="submit" class="btn btn-primary w-100" disabled>Added to cart</button>';
                        } else {
                            echo '<button type="submit" class="btn btn-primary w-100" name="addtocart">ADD</button>';
                        }
                    } else {
                        echo '<button type="submit" class="btn btn-primary w-100" name="addtocart">ADD</button>';

                    }

                }
                if (!$msg) {
                    echo ' <a href="login.php" class="btn btn-primary w-100">ADD</a>';
                }
                    echo ' </form>
    </div>';
                }

                ?>
            </div>
            <div class="col"></div>
            <div class="col-lg-4">
                <div class="card items" style="border:0;">
                    <?php
                    if (isset($_SESSION['cart']) && (count($_SESSION['cart']) >= 1)) {
                        $items = count($_SESSION['cart']);
                        echo '<h4>' . $items . ' item(s) added to cart</h4>
                                                    <a href="cart.php" class="btn btn-primary w-100">Go to cart</a>';
                    } else
                        echo '<h4>Add item(s) to proceed</h4>
                                        <button class="btn btn-primary  w-100" disabled>Go to cart</button>';
                    ?>
                </div>
            </div>
        </div>


    </div>
</body>

</html>