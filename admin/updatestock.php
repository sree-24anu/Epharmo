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
if (isset($_POST["updatebtn"])) {
    if ((!isset($_POST["category"])) && (!isset($_POST["sub_category"])) && (!isset($_POST["mname"])) && (!isset($_POST["sname"]))) {
        $validdropdown = true;
    } else {
        $id = $_REQUEST['stockid'];
        $genericname = trim(mysqli_real_escape_string($conn,$_POST["genericname"]));
        $batchno = trim(mysqli_real_escape_string($conn,$_POST["batchno"]));
        $category = trim(mysqli_real_escape_string($conn,$_POST["category"]));
        $sub_category = trim(mysqli_real_escape_string($conn,$_POST["sub_category"]));
        $qty = trim(mysqli_real_escape_string($conn,$_POST["quantity"]));
        $expiry = trim(mysqli_real_escape_string($conn,$_POST["expiry"]));
        $mname = trim(mysqli_real_escape_string($conn,$_POST["mname"]));
        $package = trim(mysqli_real_escape_string($conn,$_POST["package"]));
        $composition = trim(mysqli_real_escape_string($conn,$_POST["composition"]));
        $side_effects = trim(mysqli_real_escape_string($conn,$_POST["side_effects"]));
        $description = trim(mysqli_real_escape_string($conn,$_POST["description"]));
        $price = trim(mysqli_real_escape_string($conn,$_POST["price"]));

        $old_image = $_POST["old_image"];
        $new_image = $_FILES["new_image"]["name"];

        if ($new_image != '') {
            $currentimg = $_FILES["new_image"]["name"];
            $img_loc = $_FILES["new_image"]["tmp_name"];
        } else {
            $currentimg = $_POST["old_image"];
        }
        $img_ext = pathinfo($currentimg, PATHINFO_EXTENSION);

        if ($genericname != '' && $batchno != '' && $category != '' && $sub_category != '' && $qty != '' && $expiry != '' && $mname != '' && $package != '' && $composition != '' && $side_effects != '' && $description != '' && $price != '' && $currentimg != '') {

        // image validation
        if (($img_ext != 'jpg') && ($img_ext != 'png') && ($img_ext != 'jpeg') && ($img_ext != 'webp')) {
            $imgextalert = true;
        } else {
            $updatequery = "UPDATE `stocks` set genericname='$genericname', batchno='$batchno', category='$category', sub_category='$sub_category',qty='$qty',expiry='$expiry',mname='$mname',image='$currentimg',package='$package',composition='$composition',side_effects='$side_effects',description='$description',price='$price' WHERE id='$id'";
            $result = mysqli_query($conn, $updatequery);
            if ($result) {
                if ($new_image != '') {
                    move_uploaded_file($img_loc, "../images/" . $currentimg);
                    unlink("../images/" . $old_image);
                    header('location:viewstock.php');
                } else {
                    header('location:viewstock.php');

                }
            } else {
                die(mysqli_error($conn));
            }
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
    <link href="sty.css" rel="stylesheet">
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
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <br>
            <div class="stockcontent">
                <form action="" method="post" enctype="multipart/form-data">
                    <?php
                    $id = $_REQUEST['stockid'];
                    $edit = mysqli_query($conn, "SELECT * from `stocks` WHERE `id`=$id");
                    $row = mysqli_fetch_assoc($edit);
                    ?>

                    <div class="row flex">
                        <div class="col flex">
                            <p>Name</p>
                            <input type="text" name="genericname" value="<?php echo $row['genericname']; ?>" required>
                        </div>
                        <div class="col flex">
                            <p>Batch number</p>
                            <input type="text" name="batchno" value="<?php echo $row['batchno']; ?>" required>
                        </div>
                    </div>
                    <div class="row flex">
                        <div class="col flex">
                            <p>Category</p>
                            <select name="category" id="cat">

                                <?php
                                $category = $row['category'];
                                if ($category == "Allopathy") {
                                    echo '
                                <option value="Allopathy" selected>Allopathy</option>
                                <option value="Ayurveda">Ayurveda</option>';
                                } else {
                                    echo '
                                <option value="Allopathy">Allopathy</option>
                                <option value="Ayurveda" selected>Ayurveda</option>';
                                }
                                ?>

                            </select>

                        </div>

                        <div class="col flex">
                            <p>Sub-category</p>
                            <input type="hidden" name="selected_subcategory" value="selected_subcategory">
                            <select name="sub_category" id="subcategory">

                                <!-- Category dropdown -->
                                <!-- <option selected disabled>Select</option> -->
                                <option selected><?php echo $row['sub_category']; ?></option>

                                <?php
                                $option = mysqli_query($conn, "Select * from categories where cname!='$row[sub_category]' and categorie='$row[category]';");
                                while ($option_row = mysqli_fetch_assoc($option)) {
                                    echo '<option value="' . $option_row['cname'] . '">' . $option_row['cname'] . '</option>';
                                }
                                ?>


                            </select>
                        </div>


                    </div>

                    <div class="row flex">
                        <div class="col flex">
                            <p>Manufacture</p>
                            <select name="mname">
                                <!-- Manufacture dropdown -->
                                <option selected value="<?php echo $row['mname']; ?>"><?php echo $row['mname']; ?>
                                </option>
                                <?php
                                $manufacture = mysqli_query($conn, "SELECT mname from `manufactures` where mname!='$row[mname]';");
                                while ($manu_row = mysqli_fetch_assoc($manufacture)) {
                                    echo '<option value="' . $manu_row["mname"] . '">' . $manu_row["mname"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col flex">
                            <p>Quantity</p>
                            <input type="text" name="quantity" value="<?php echo $row['qty']; ?>" required>
                        </div>
                    </div>

                    <div class="row flex">
                        <div class="col flex">
                            <p>Expiry date</p>
                            <input type="date" name="expiry" value="<?php echo $row['expiry']; ?>" required>
                        </div>
                        <div class="col flex">
                            <p>Pack and quantity per unit</p>
                            <input type="text" name="package" value="<?php echo $row['package']; ?>" required>
                        </div>
                    </div>

                    <div class="row flex">
                        <div class="col flex">
                            <p>Description</p>
                            <textarea rows=2 cols=23 name="description"
                                required><?php echo $row['description']; ?></textarea>
                        </div>
                        <div class="col flex">
                            <p>Composition</p>
                            <textarea rows=2 cols=23 name="composition"
                                required><?php echo $row['composition']; ?></textarea>
                        </div>
                    </div>
                    <div class="row flex">
                        <div class="col flex">
                            <p>Side effects</p>
                            <textarea rows=2 cols=23 name="side_effects"
                                required><?php echo $row['side_effects']; ?></textarea>
                        </div>
                        <div class="col flex">
                            <p>Price</p>
                            <input type="text" name="price" value="<?php echo $row['price']; ?>" required>
                        </div>
                    </div>
                    <div class="row flex">
                        <div class="col flex img">
                            <p>Image</p>
                            <image src="../images/<?php echo $row['image']; ?> " alt=""
                                style="width:180px; height: 100px; margin-bottom: 20px; margin-left: 208px; margin-right: 20px;">
                                or choose another image
                                <input type="file" name="new_image">
                                <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
                        </div>

                    </div>

                    <div class="button">
                        <input type="submit" value="Update" name="updatebtn">
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
                echo '<div id="alertmsg" class="alert alert-secondary alertmsg" role="alert">
                        <div>Select valid Caterory,Sub-category,Supplier and Manufacturer</div>
                    </div>';
            }
            if ($imgextalert == true) {
                echo '<div id="alertmsg" class="alert alert-secondary alertmsg" role="alert">
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
                var selected_subcategory = $('.selected_subcategory').val();
                console.log(selected_subcategory);
                console.log(category);

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