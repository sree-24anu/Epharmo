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
    <link href="styles.css" rel="stylesheet">
</head>

<body>
<div class="navbar">
        <?php
        include_once ('navbar.php');
        ?>
    </div>
    <div class="container search_container">
        <div class="row my-3">
            <div class="col"></div>
            <div class="col-lg-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="d-flex" role="search" id="search_form">
                    <input class="form-control me-2" type="search" placeholder="Search" name="find" id="search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit" name="search">Search</button>
                </form>
            </div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="containers">
                    <?php
                        include_once ('admin/connection.php');
                        if (isset($_GET['find'])) {
                            $noresult = true;
                            $find = $_GET['find'];
                            if($find == '')
                            {
                                echo '<div class="card no_search_items"  style="border:0;">
                                    Enter a valid search 
                                    </div>'; 
                            }
                            echo '<div class="search">
                                    <h3>Search result for ' . $_GET['find'] . '</h3>';
                            $sqlquery = "SELECT * FROM `stocks` WHERE MATCH(genericname) against ('$find') and `qty`!='0';";
                            $result = mysqli_query($conn, $sqlquery);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '  <div class="card search_items" >
                                            <a href="product.php?id=' . $row["id"] . '&page=proallopathy">
                                                <form action="insertintocart.php" method="POST">
                                                    <div class="card-header" >
                                                        <img src="images/' . $row['image'] . '" >
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="item-details">
                                                                <h4>' . $row['genericname'] . '</h4>
                                                                <p>' . $row['package'] . '</p>
                                                                <h4>' . $row['price'] . '</h4>
                                                        </div>
                                                        <div class="btn">
                                                    
                                                            <input type="hidden" name="name" value="' . $row['genericname'] . '">
                                                            <input type="hidden" name="price" value="' . $row['price'] . '">  
                                                            <input type="hidden" name="img" value="' . $row['image'] . '">
                                                            <input type="hidden" name="pro_id" value="' . $row['id'] . '">
                                                            <input type="hidden" name="page_return" value="search.php?find='.$find.'"> ';

                                                            if ($msg) {
                                                                if (isset($_SESSION['cart'])) {
                                                                    $myitems = array_column($_SESSION['cart'], 'Itemname');
                                                                    if (in_array($row['genericname'], $myitems)) {
                                                                        echo '<button type="submit" class="btn btn-primary w-100" disabled>Added to cart</button>';
                                                                    } else {
                                                                        echo '<button type="submit" class="btn btn-primary w-100" style="align:end;" name="addtocart">ADD</button>';
                                                                    }
                                                                } else {
                                                                    echo '<button type="submit" class="btn btn-primary w-100" style="align:end;" name="addtocart">ADD</button>';
                                                                }
                                                            }
                                                            if (!$msg) {
                                                                echo ' <a href="login.php" class="btn btn-primary w-100">ADD</a>';
                                                            }

                                                echo '  </div>
                                                    </div>
                                                </form>
                                            </a>
                                        </div><br>';
                                        $noresult = false;
                                        }
                                        if ($noresult) {
                                            echo '<div class="card no_search_items"  style="border:0;">
                                                    No result found of ' . $find . '
                                                    </div>';
                                            }
                                            $firstchar = $find[0];
                                            $sqlquery2 = "SELECT * FROM `stocks` WHERE genericname like '%$firstchar%' and NOT MATCH(genericname) AGAINST ('$find') and `qty`!='0'; ";
                                            $result2 = mysqli_query($conn, $sqlquery2);
                                            if(mysqli_num_rows($result2)>=1)
                                            {
                                                echo '<br>  <h4>Related search</h4>';
                                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                                    echo '  <div class="card search_items" >
                                                                <a href="product.php?id=' . $row2["id"] . '&page=proallopathy">
                                                                <form action="insertintocart.php" method="POST">

                                                                    <div class="card-header" >
                                                                        <img src="images/' . $row2['image'] . '" >
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="item-details">
                                                                            <h4>' . $row2['genericname'] . '</h4>
                                                                            <p>' . $row2['package'] . '</p>
                                                                            <h4>' . $row2['price'] . '</h4>
                                                                        </div>
                                                                        <div class="btn">
                                                                            <input type="hidden" name="name" value="' . $row2['genericname'] . '">
                                                                            <input type="hidden" name="price" value="' . $row2['price'] . '">  
                                                                            <input type="hidden" name="img" value="' . $row2['image'] . '">
                                                                            <input type="hidden" name="pro_id" value="' . $row2['id'] . '">
                                                                            <input type="hidden" name="page_return" value="search.php?find='.$find.'">';

                                                                            if ($msg) {
                                                                                if (isset($_SESSION['cart'])) {
                                                                                    $myitems = array_column($_SESSION['cart'], 'Itemname');
                                                                                    if (in_array($row2['genericname'], $myitems)) {
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

                                                                echo '  </div>
                                                                    </div>
                                                                </form>
                                                            </a>
                                                        </div>
                                                    <br>';
                                                    $noresult = false;
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>    
                                </div>
                            </div>

                            <br><br>
                            <div class="col-lg-4">
                                <div class="card items" style="border:0;">                        
                                    <?php 
                                        if (isset($_SESSION['cart']) && (count($_SESSION['cart'])>=1)) {
                                            $items=count($_SESSION['cart']);
                                            echo '<h4>'.$items.' added to cart</h4>
                                                    <a href="cart.php" class="btn btn-primary w-100">Go to cart</a>';
                                        }
                                        else
                                        echo '<h4>Add item(s) to proceed</h4>
                                        <button class="btn btn-primary  w-100" disabled>Go to cart</button>';
                                    ?>
                                </div>
                            </div>
                </div>
            </div>
        
    <script>

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