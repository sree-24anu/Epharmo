<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once ("connection.php");
$presentalert = '';
if (isset($_POST["updatebtn"])) {
    $id = $_REQUEST["id"];
    $mname = trim(mysqli_real_escape_string($conn,$_POST["manufacturer"]));
    $phone = trim(mysqli_real_escape_string($conn,$_POST["phone"]));
    $address = trim(mysqli_real_escape_string($conn,$_POST["address"]));
    $email = trim(mysqli_real_escape_string($conn,$_POST["email"]));

    if ($mname != '' && $phone != '' && $email != '' && $address != '') 
    {
        // phone number validation
        $phonepattern = '/^[0-9]{10,10}$/';
        if (preg_match($phonepattern, $phone) && $phone[0] >= 6) 
        {
            // email validation
            $domain = substr(strchr($email, '@'), 1);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {

        $check = mysqli_query($conn, "SELECT * from `manufactures` WHERE `mname`='$mname' and `id`!='$id';");
        if (mysqli_num_rows($check) > 0) {
            $presentalert = "The manufacturer is already present....";
        } else {
            $updatequery = "UPDATE `manufactures` set `mname`='$mname', `email`='$email', `phoneno`='$phone', `address`='$address' WHERE id='$id'";
            $result = mysqli_query($conn, $updatequery);
            if ($result) {
                header('location:viewmanufacturer.php');
            }
        }
        } else {

            $presentalert = "Invalid Email!! Enter valid email address.";

        }

            } else {
                $presentalert = "Invalid phone number!! Enter a valid phone number.";
            }
        
    } else {
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
            <?php include_once ('sidebar.php'); ?>
        </div>

        <div class="rightpanel">
            <h1>Manufacture Details</h1>
            <!-- breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="viewmanufacturer.php">View</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>

            <form action="" method="post">

                <div class="content">

                    <?php
                    $id = $_REQUEST['id'];
                    $update = mysqli_query($conn, "SELECT * from `manufactures` WHERE `id`=$id");
                    $row = mysqli_fetch_assoc($update);
                    ?>
                    <div class="flex">
                        <label>Manufacturer</label>
                        <input type="text" name="manufacturer" value="<?php echo $row['mname']; ?>">
                    </div>
                    <div class="flex">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="flex">
                        <label>Phone number</label>
                        <input type="text" name="phone" pattern="[6-9]{1}[0-9]{9}"
                            value="<?php echo $row['phoneno']; ?>">
                    </div>
                    <div class="flex">
                        <label>Address</label>
                        <textarea rows=3 cols=23 name="address"><?php echo $row['address']; ?></textarea>
                    </div>
                    <div class="button">
                        <input type="submit" value="Update" name="updatebtn">
                    </div>
                </div>
            </form>
            <?php
            if ($presentalert) {
                echo '<div id="alertmsg" class="alert alert-secondary alertmsg text-center" role="alert">
                    '.$presentalert.'
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