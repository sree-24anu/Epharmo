<?php
session_start();
require_once '../vendor/autoload.php';

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;


if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
            include_once('connection.php');
            $presentalert = '';
            if (isset($_POST["addbtn"])) {

                $mname = trim(mysqli_real_escape_string($conn,$_POST["manufacture"]));
                $phone = trim(mysqli_real_escape_string($conn,$_POST["phone"]));
                $address = trim(mysqli_real_escape_string($conn,$_POST["address"]));
                $email = trim(mysqli_real_escape_string($conn,$_POST["email"]));

                

                    if($mname != '' && $phone != '' && $email != '' && $address != '')
                    {
                        // phone number validation
                        $phonepattern = '/^[0-9]{10,10}$/';
                        if (preg_match($phonepattern, $phone) && $phone[0] >= 6) {
                        
                            // email validation
                            $validator = new EmailValidator();
                            $isValid = $validator->isValid($email, new DNSCheckValidation());

                            $domain = substr(strchr($email, '@'), 1);
                            if (filter_var($email, FILTER_VALIDATE_EMAIL) && ($isValid)) 
                            {

                        $check = mysqli_query($conn, "SELECT * from `manufactures` WHERE `mname`='$mname'");
                        if (mysqli_num_rows($check) > 0) {
                            $presentalert = "The manufacturer is already present...." ;
                        } else {
                            $addquery = "INSERT into `manufactures` (mname,email,phoneno,address) values('$mname','$email','$phone','$address')";
                            $result = mysqli_query($conn, $addquery);
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
    <div class="contain">
        <div class="sidebar">
            <?php include_once('sidebar.php'); ?>
        </div>
        <div class="rightpanel">
            <h1>Manufacture</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="viewmanufacturer.php">View</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
            <form action="" method="post">
                <div class="content">
                    <div class="flex">
                        <label>Manufacturer</label>
                        <input type="text" name="manufacture" required>
                    </div>
                    <div class="flex">
                        <label>Email</label>
                        <input type="text" name="email" required>
                    </div>
                    <div class="flex">
                        <label>Phone number</label>
                        <input type="tel" name="phone" min="10" max="10" required>
                    </div>
                    <div class="flex">
                        <label>Address</label>
                        <textarea rows=3 cols=23 name="address" required></textarea>
                    </div>
                    
                    <div class="button">
                        <input type="submit" value="Add" name="addbtn">
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
    <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>

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