<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once("connection.php");
$imgextalert = false;
$presentalert = '';

if (isset($_POST["updatebtn"])) {
    $id = $_REQUEST['id'];
    $category = trim(mysqli_real_escape_string($conn,$_POST["category"]));
    $subcategory = trim(mysqli_real_escape_string($conn,$_POST["subcategory"]));
    $status = trim(mysqli_real_escape_string($conn,$_POST["status"]));

    $old_image = $_POST["old_image"];
    $new_image = $_FILES["new_image"]["name"];

    if($new_image != '')
    {
        $currentimg=$_FILES["new_image"]["name"];
        $img_loc = $_FILES["new_image"]["tmp_name"];
    }
    else
    {
        $currentimg=$_POST["old_image"];
    }
    $img_ext = pathinfo($currentimg, PATHINFO_EXTENSION);

    if($category != '' && $subcategory != '' && $status != '' && $currentimg != '')
    {

    $check = mysqli_query($conn, "SELECT * from `categories` WHERE `cname`='$subcategory' and `categorie`='$category' and `id`!='$id';");
    if (mysqli_num_rows($check) > 0) {
        $presentalert = "The categorie is already present....!!";
    } else {
    // image validation
    if (($img_ext != 'jpg') && ($img_ext != 'png') && ($img_ext != 'jpeg') && ($img_ext != 'webp')) {
        // echo "invalid extension";
        $imgextalert = true;
    } else {
    $updatequery = "UPDATE `categories` set categorie='$category', cname='$subcategory', status='$status', image='$currentimg' WHERE id='$id'";
    $result = mysqli_query($conn, $updatequery);
    if ($result) {
        if( $new_image != '' )
        {
        move_uploaded_file($img_loc, "../images/" . $currentimg);
        unlink("../images/".$old_image);
        header('location:viewcategories.php');
        }
        else
        {
         header('location:viewcategories.php');

        }
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
             include_once('sidebar.php');
            ?>
        </div>

        <div class="rightpanel">
            <h1>Categories</h1>
            <!-- breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="viewcategories.php">View</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="content">
                    <?php
                    $id = $_REQUEST['id'];
                    $edit = mysqli_query($conn, "SELECT * from `categories` WHERE `id`=$id");
                    $row = mysqli_fetch_assoc($edit);
                    ?>
                    <div class="flex">
                        <label>Category</label>
                        <select name="category">
                            <?php
                            $status = $row['categorie'];
                            if ($status == "Allopathy") {
                                echo '<option value="" disabled ></option>
                                <option value="Allopathy" selected>Allopathy</option>
                                <option value="Ayurveda">Ayurveda</option>';
                            } else {
                                echo '<option value="" disabled ></option>
                                <option value="Allopathy">Allopathy</option>
                                <option value="Ayurveda" selected>Ayurveda</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex">
                        <label>Sub-category</label>
                        <input type="text" name="subcategory" value="<?php echo $row['cname']; ?>" required>
                    </div>
                    <div class="flex">
                        <label>Status</label>
                        <select name="status">
                            <?php
                            $status = $row['status'];
                            if ($status == "Avaliable") {
                                echo '<option value="" disabled ></option>
                                <option value="Avaliable" selected>Avaliable</option>
                                <option value="Unavaliable">Unavaliable</option>';
                            } else {
                                echo '<option value="" disabled ></option>
                                <option value="Avaliable">Avaliable</option>
                                <option value="Unavaliable" selected>Unavaliable</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex">
                        <label>Image</label>
                        <div class="display_img">
                        <image src="../images/<?php echo $row['image']; ?> " alt="" style="width:100%; height: 100px; margin-bottom: 20px;">
                        or choose another image <br> <br>
                        <input type="file" name="new_image">
                        <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" name="updatebtn" value="Update">
                    </div>
                </div>
            </form>

             <?php
              if ($presentalert) {
                echo '<div id="alertmsg" class="alert alert-secondary alertmsg text-center" role="alert">
                        <p> '. $presentalert .' </p>
                    </div>';
            } else if ($imgextalert == true) {
             echo '<div id="alertmsg" class="alert alert-secondary alertmsg" role="alert">
                    <div>Invalid file!!! Upload a valid image file</div>
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