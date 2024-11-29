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
    <style>
        #btn
        {
            left: 0px;
        }
    </style>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="navbar">
        <?php include_once ('navbar.php'); ?>
    </div>
    <!-- sub-nav -->
    <div class="sub-nav">
        <div class="buttons">
            <div id="btn"></div>
            <button type="button" class="togglebtn" onclick="allopathy()">Allopathy</button>
            <button type="button" class="togglebtn" onclick="aiyurvedh()">Ayurveda</button>
        </div>
    </div>
    <!-- search bar -->
    <div class="search" id="search_container" style="margin-top:120px">
        <div class="row">
            <div class="col"></div>
            <div class="col-lg-6">
                <form action="search.php" method="get" class="d-flex" role="search" id="search_form">
                    <input class="form-control me-2" type="search" placeholder="Search" name="find" id="search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit" name="search">Search</button>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>

<div class="main" id="main">
    <!-- vertical nav-bar -->
    <div class="verticalbar">
        <?php
        include_once ("admin/connection.php");

        echo '<form action="" method="post">
                <button type="submit" name="all">
                    <div class="box" style="background-image: url(images/allopathy.jpg);">
                        <div class="content">
                            All
                            <input type="hidden" name="categorytype" value="All">
                        </div>
                    </div>
                </button>
             </form>';

        $sqlquery = "SELECT * From `categories` where `categorie`='Allopathy'";
        $result = mysqli_query($conn, $sqlquery);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['status'] == 'Avaliable') {
                $category = $row['cname'];
                $checkqtyres = mysqli_query($conn, "SELECT qty From `stocks` WHERE `sub_category`='$category'");
                $checkqtyrows = mysqli_num_rows($checkqtyres);
                if ($checkqtyrows != 0) {
                    $row_qty = mysqli_fetch_assoc($checkqtyres);

                    if ($row_qty['qty'] > 0 && $checkqtyrows != 0) {
                        $loc = $row['image'];
                        $cname = $row['cname'];
                        echo '<form action="" method="post">
                            <button type="submit" name="category_box">
                                <div class="box" style="background-image: url(images/' . $loc . ');">
                                    <div class="content">
                                        ' . $cname . '
                                        <input type="hidden" name="categorytype" value="' . $cname . '">
                                    </div>
                                </div>
                            </button>
                        </form>';
                    }
                }

            }
        }
        ?>
    </div>
    <br>
    <!-- displaying products -->
    <div class="display">
        <?php
        // if any categories is pressed
        if (isset($_POST["category_box"])) {
            $categorytype = $_POST["categorytype"];
            echo '<h1 style="padding-left:20px;">' . $categorytype . '</h1><br>'; ?>
            <div class="container-fluid overflow-hidden text-center">
                <div class="row g-5 mx-2 align-items-start">
                    <?php
                    $query = 'Select * from stocks where sub_category="' . $categorytype . '" and  category="Allopathy" and qty>"0"';
                    $result = mysqli_query($conn, $query);
                    // $checkqtyrows = mysqli_num_rows($result);
                    // echo $checkqtyrows;
                
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row["id"];
                        $genericname = $row["genericname"];
                        $package = $row["package"];
                        $image = $row["image"];
                        $price = $row["price"];
                        $category = $row["category"];

                        echo '<div class="col col-lg-2">
                                <form action="insertintocart.php" method="POST">
                                    <a href="product.php?id=' . $row["id"] . '&page=proallopathy">
                                        <div class="card" style="width: 10rem; border-style: none; position: static;">
                                            <img src="images/' . $image . '" class="card-img-top" alt="..." style="height:120px;">
                                            <div class="card-body">
                                                <h5 class="card-title" style="min-height: 66px;">' . $genericname . '</h5>
                                                <p class="card-text">' . $package . '</p>
                                                <p class="card-text">Rs.' . $price . '</p>
                                    
                                                <input type="hidden" name="name" value="' . $genericname . '">
                                                <input type="hidden" name="price" value="' . $price . '">
                                                <input type="hidden" name="img" value="' . $image . '">
                                                <input type="hidden" name="pro_id" value="' . $id . '">
                                                <input type="hidden" name="page_return" value="' . $category . '">';
                    
                                                if ($msg) {
                                                // if product already added to cart
                                                    if (isset($_SESSION['cart'])) 
                                                    {
                                                        $myitems = array_column($_SESSION['cart'], 'Itemname');
                                                        if (in_array($genericname, $myitems)) {
                                                            echo '<button type="submit" class="btn btn-primary w-100" disabled>Added to cart</button>';
                                                        } else {
                                                            echo '<button type="submit" class="btn btn-primary w-100" name="addtocart">ADD</button>';
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '<button type="submit" class="btn btn-primary w-100" name="addtocart">ADD</button>';
                            
                                                    }
                            
                                                }
                                                //   if not logged in redirect to login page
                                                if (!$msg) {
                                                    echo ' <a href="login.php" class="btn btn-primary w-100">ADD</a>';
                                                }
                                     echo '  </div>
                                        </div>
                                    </a>
                                </form>
                            </div>';
                    } ?>
                </div>
            </div>

        <?php } 
            // if no categories is pressed
            else {
                echo '<br>';
                $query = "Select * from stocks where category='Allopathy' and qty>'0';";
                $result = mysqli_query($conn, $query);

                echo '<div class="container-fluid overflow-hidden text-center">
                        <div class="row g-5 mx-2 row-cols-md-3 row-cols-sm-3 align-items-start">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row["id"];
                                $genericname = $row["genericname"];
                                $package = $row["package"];
                                $image = $row["image"];
                                $price = $row["price"];
                                $category = $row["category"];

                                $check_status = mysqli_query($conn, "SELECT * From `categories` where `status`='Avaliable' and `cname`='$row[sub_category]' and `categorie`='Allopathy';");
                                $check_status_rows = mysqli_num_rows($check_status);
                                if ($check_status_rows != 0) {
                                    echo '<div class="col col-lg-2">
                                            <form action="insertintocart.php" method="POST">
                                                <a href="product.php?id=' . $row["id"] . '&page=proallopathy">
                                                    <div class="card" style="width: 10rem; border-style: none; position: static;">
                                                        <img src="images/' . $image . '" class="card-img-top" alt="..." style="height:120px;">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="min-height: 66px;">' . $genericname . '</h5>
                                                            <p class="card-text">' . $package . '</p>
                                                            <p class="card-text">Rs.' . $price . '</p>

                                                            <input type="hidden" name="name" value="' . $genericname . '">
                                                            <input type="hidden" name="price" value="' . $price . '">  
                                                            <input type="hidden" name="img" value="' . $image . '">
                                                            <input type="hidden" name="pro_id" value="' . $id . '">
                                                            <input type="hidden" name="page_return" value="' . $category . '">';
                                                            
                                                            if ($msg) {
                                                                if (isset($_SESSION['cart'])) 
                                                                {
                                                                    $myitems = array_column($_SESSION['cart'], 'Itemname');
                                                                    if (in_array($genericname, $myitems)) {
                                                                        echo '<button type="submit" class="btn btn-primary w-100" disabled>Added to cart</button>';
                                                                    } else {
                                                                        echo '<button type="submit" class="btn btn-primary w-100" name="addtocart">ADD</button>';
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    echo '<button type="submit" class="btn btn-primary w-100" name="addtocart">ADD</button>';

                                                                }

                                                            }
                                                            if (!$msg) {
                                                                echo ' <a href="login.php" class="btn btn-primary w-100">ADD</a>';
                                                            }

                                                    echo '</div>  
                                                    </div>
                                                </a>
                                            </form>
                                        </div>';
                                }
                            }
                
                echo '  </div>
                    </div>';
            }

            ?>
              


    </div>
            <br>
            <br><br>
            <?php
            if (isset($_SESSION['cart']) && (count($_SESSION['cart'])>=1)) {
                $items=count($_SESSION['cart']);
            echo '<div class="cart_msg">
                    <div class="cart_msg_left">
                        <img src="usage/images/cart.png" alt="">
                        <p>'.$items .' Item(s) added to the cart</p>
                    </div>
                    <a class="btn btn-primary btn-sm cart_msg_btn" href="cart.php">View cart</a>
                </div>';
            }
            ?>


</div>

<script>
    function aiyurvedh() {
        window.location = "proayurvedh.php";
    }

    let search = document.getElementById("search");
    let search_form = document.getElementById("search_form");

    search_form.addEventListener("submit", function (event) { 
        let search_value = search.value.trim();
        if(search_value == '')
        {
            event.preventDefault();
        }
    });
</script>

</body>

</html>