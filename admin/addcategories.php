<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once ("connection.php");
$presentalert = '';
$imgextalert = false;
if (isset($_POST["addbtn"])) {
    $category = trim(mysqli_real_escape_string($conn,$_POST["category"]));
    $subcategory = trim(mysqli_real_escape_string($conn,$_POST["subcategory"]));
    $status = trim(mysqli_real_escape_string($conn,$_POST["status"]));

    $img_loc = $_FILES["image"]["tmp_name"];
    $img_name = trim(mysqli_real_escape_string($conn,$_FILES["image"]["name"]));
    $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);

    if($category != '' && $subcategory != '' && $status != '' && $img_loc != '')
    {

    $check = mysqli_query($conn, "SELECT * from `categories` WHERE `cname`='$subcategory' and `categorie`='$category'");
    if (mysqli_num_rows($check) > 0) {
        $presentalert = "The categorie is already present....!!";
    } else {
        // image validation
        if (($img_ext != 'jpg') && ($img_ext != 'png') && ($img_ext != 'jpeg') && ($img_ext != 'webp')) {
            $imgextalert = true;
        } else {
            $addquery = "INSERT into `categories` (categorie,cname,status,image) values('$category','$subcategory','$status','$img_name')";
            $result = mysqli_query($conn, $addquery);
            if ($result) {
                move_uploaded_file($img_loc, "../images/" . $img_name);
                header('location:viewcategories.php');
            } else {
                die(mysqli_error($conn));
            }
        }
    }
    }
    else
    {
        $presentalert = "Please enter all the fields!!";
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
</head>

<body>

    <div class="panel">
        <div class="sidebar">
            <?php
            include_once ('sidebar.php');
            ?>
        </div>
        <div class="rightpanel">

            <h1>Categories</h1>
            <!-- breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="viewcategories.php">View</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>

            <div class="content">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="flex">
                        <label>Category</label>
                        <select name="category" required>
                            <option value="Allopathy">Allopathy</option>
                            <option value="Ayurveda">Ayurveda</option>
                        </select>
                    </div>
                    <div class="flex">
                        <label>Sub-Category</label>
                        <input type="text" name="subcategory" required>
                    </div>
                    <div class="flex">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="Avaliable">Avaliable</option>
                            <option value="Unavaliable">Unavaliable</option>
                        </select>
                    </div>
                    <div class="flex">
                        <label>Image</label>
                        <input type="file" name="image" id="image" required>
                    </div>
                    <div class="button">
                        <input type="submit" value="Add" name="addbtn">
                    </div>
                </form>

            </div>
            <br>
            <?php
            if ($presentalert) {
                echo '<div id="alertmsg" class="alert alert-secondary alertmsg text-center" role="alert">
                        <p> '. $presentalert .' </p>
                    </div>';
            } else if ($imgextalert == true) {
                echo '<div id="alertmsg" class="alert alert-secondary alertmsg text-center" role="alert">
                        <p>Invalid file!!! Upload a valid image file</p>
                    </div>';
            }
            ?>

        </div>
    </div>
    <script>
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