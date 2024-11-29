<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once ('connection.php');
$presentalert = '';
$validdropdown = false;
$imgextalert = false;
if (isset($_POST["addbtn"])) {
    if ((!isset($_POST["category"])) || (!isset($_POST["sub_category"])) || (!isset($_POST["mname"]))) {
        $validdropdown = true;
    } else {
        $genericname =  trim(mysqli_real_escape_string($conn,$_POST["genericname"]));
        $batchno =  trim(mysqli_real_escape_string($conn,$_POST["batchno"]));
        $category =  trim(mysqli_real_escape_string($conn,$_POST["category"]));
        $sub_category =  trim(mysqli_real_escape_string($conn,$_POST["sub_category"]));
        $qty =  trim(mysqli_real_escape_string($conn,$_POST["quantity"]));
        $expiry =  trim(mysqli_real_escape_string($conn,$_POST["expiry"]));
        $mname =  trim(mysqli_real_escape_string($conn,$_POST["mname"]));
        $package =  trim(mysqli_real_escape_string($conn,$_POST["package"]));
        $composition = trim(mysqli_real_escape_string($conn,$_POST["composition"]));
        $side_effects = trim(mysqli_real_escape_string($conn,$_POST["side_effects"]));
        $description = trim(mysqli_real_escape_string($conn,$_POST["description"]));
        $price =  trim(mysqli_real_escape_string($conn,$_POST["price"]));

        $img_loc =  trim(mysqli_real_escape_string($conn,$_FILES["image"]["tmp_name"]));
        $img_name =  trim(mysqli_real_escape_string($conn,$_FILES["image"]["name"]));
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);

        // $check = mysqli_query($conn, "SELECT * from `stocks` WHERE `genericname`='$genericname'");
        // if (mysqli_num_rows($check) > 0) {
        //     $presentalert = true;
        // } else {
        
        if ($genericname != '' && $batchno != '' && $category != '' && $sub_category != '' && $qty != '' && $expiry != '' && $mname != '' && $package != '' && $composition != '' && $side_effects != '' && $description != '' && $price != '' && $img_name != '') {
            // image validation
            if (($img_ext != 'jpg') && ($img_ext != 'png') && ($img_ext != 'jpeg') && ($img_ext != 'webp')) {
                $imgextalert = true;
            } else {

                $addquery = "INSERT INTO `stocks`(`id`, `genericname`, `batchno`, `category`, `sub_category`, `qty`, `expiry`, `mname`, `image`, `package`, `composition`, `side_effects`, `description`, `price`) 
                        VALUES ('','$genericname','$batchno','$category','$sub_category','$qty','$expiry','$mname','$img_name','$package',' $composition','$side_effects','$description','$price');";

                $result = mysqli_query($conn, $addquery);
                if ($result) {
                    move_uploaded_file($img_loc, "../images/" . $img_name);
                    header('location:viewstock.php');
                } else {
                    die(mysqli_error($conn));
                }
                // echo "success";   
            }
        } else {
            $presentalert = "Please enter all the fields!!";
        }
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
    <style>

    </style>
</head>

<body>
    <div class="panel">
        <div class="sidebar">
            <?php
            include_once ('sidebar.php');
            ?>
        </div>
        <div class="rightpanel">
            <h1>Stock Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="viewstock.php">View</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
            <br>
            <div class="stockcontent">
                <form action="" method="post" enctype="multipart/form-data">


                    <div class="row flex">
                        <div class="col flex">
                            <label>Name</label>
                            <input type="text" name="genericname" required>
                        </div>
                        <div class="col flex">
                            <p>Batch number</p>
                            <input type="text" name="batchno" required>
                        </div>
                    </div>
                    <div class="row flex">
                        <div class="col flex">
                            <p>Category</p>
                            <select name="category" id="cat">
                                <option selected disabled>Select</option>
                                <option value="Allopathy">Allopathy</option>
                                <option value="Ayurveda">Ayurveda</option>
                            </select>

                        </div>

                        <div class="col flex">
                            <p>Sub-category</p>
                            <select name="sub_category" id="subcategory">

                                <!-- Category dropdown -->
                                <option selected disabled>Select</option>




                            </select>
                        </div>


                    </div>

                    <div class="row flex">
                        <div class="col flex">
                            <p>Manufacture</p>
                            <select name="mname">
                                <!-- Manufacture dropdown -->
                                <option selected disabled>Select</option>
                                <?php
                                $manufacture = mysqli_query($conn, "SELECT mname from `manufactures`");
                                while ($row = mysqli_fetch_assoc($manufacture)) {
                                    echo '<option value="' . $row["mname"] . '">' . $row["mname"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col flex">
                            <p>Quantity</p>
                            <input type="text" name="quantity" required>
                        </div>
                    </div>

                    <div class="row flex">

                        <div class="col flex">
                            <p>Expiry date</p>
                            <input type="date" name="expiry" required>
                        </div>
                        <div class="col flex">
                            <p>Pack and quantity per unit</p>
                            <input type="text" name="package" required>
                        </div>
                    </div>

                    <div class="row flex">
                        <div class="col flex img">
                            <p>Image</p>
                            <input type="file" name="image" required>
                        </div>
                        <div class="col flex">
                            <p>Description</p>
                            <textarea rows=2 cols=23 name="description"></textarea>
                        </div>

                    </div>
                    <div class="row flex">
                        <div class="col flex">
                            <p>Composition</p>
                            <textarea rows=2 cols=23 name="composition"></textarea>
                        </div>
                        <div class="col flex">
                            <p>Side effects</p>
                            <textarea rows=2 cols=23 name="side_effects"></textarea>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col price">
                            <p>Price</p>
                            <input type="text" name="price" required>
                        </div>
                    </div>

                    <div class="button">
                        <input type="submit" value="Add" name="addbtn">
                    </div>
                </form>

            </div>
            <?php
            if ($presentalert) {
                echo '<div id="alertmsg" class="alert text-center alert-secondary alertmsg" role="alert">
                        <div> ' . $presentalert . ' </div>
                    </div>';
            }
            if ($validdropdown == true) {
                echo '<div id="alertmsg" class="alert text-center alert-secondary alertmsg" role="alert">
                        <div>Select valid Caterory,Sub-category,Supplier and Manufacturer</div>
                    </div>';
            }
            if ($imgextalert == true) {
                echo '<div id="alertmsg" class="alert text-center alert-secondary alertmsg" role="alert">
                        <p>Invalid file!!! Upload a valid image file</p>
                    </div>';
            }
            ?>

        </div>
    </div>
    <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>

    <script>
        $(document).ready(function () {
            $('#cat').on('change', function (e) {
                e.preventDefault();
                var category = this.value;
                //  console.log(category);
                
                $.ajax({
                    type: "post",
                    url: "code.php",
                    data: {
                        'view_subcategory': true,
                        category: category
                    },

                    success: function (response) {
                        // console.log(response);
                        $('#subcategory').html(response);


                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {

            var alertmsg = document.getElementById("alertmsg");

            window.onclick = function (event) {
                if (event.target != alertmsg) {
                    alertmsg.style.display = "none";
                }
            }
        });
    </script>
</body>

</html>