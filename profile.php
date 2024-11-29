<?php
session_start();
require_once 'vendor/autoload.php';

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit();
}

include_once 'admin/connection.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user_login WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User data not found";
    exit();
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_POST['upd_btn']))
    {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    if ($name != '' && $username != '' && $email != '' && $contactno != '') 
    {
        // phone number validation
        $phonepattern = '/^[0-9]{10,10}$/';
        if (preg_match($phonepattern, $contactno) && $contactno[0] >= 6) 
        {
            // email validation
             $validator = new EmailValidator();
             $isValid = $validator->isValid($email, new DNSCheckValidation());
 
            $domain = substr(strchr($email, '@'), 1);
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && ($isValid))  
            {
                // email and user already exists validation
                $check_username = "SELECT * FROM user_login WHERE username='$username' and id!='$user_id'";
                $check_email = "SELECT * FROM user_login WHERE email='$email' and id!='$user_id'";
                $result_username = mysqli_query($conn, $check_username);
                $result_email = mysqli_query($conn, $check_email);

                if (mysqli_num_rows($result_username) > 0) {
                    $error = "Username already exists";
                } else if (mysqli_num_rows($result_email) > 0) {
                    $error = "Email already exists";
                } else {
                    $update_query = "UPDATE user_login SET name='$name', username='$username', email='$email', contactno='$contactno' WHERE id = '$user_id'";
                    if (mysqli_query($conn, $update_query)) {
                        header("location: profile.php");
                        exit();
                    } else {
                        echo "Error updating profile: " . mysqli_error($conn);
                        exit();
                    }
                } 
            } else {
                $error = "Invalid email ";
            }
        } else {
        $error = "Invalid phone number";
        } 
    } else {
    $error = "Please fill all the fields!!";
    }
   }


    if(isset($_POST['delete_btn']))
    {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];

    $delete_query = "DELETE FROM `user_login` WHERE id = '$user_id'";
    if (mysqli_query($conn, $delete_query)) {
        session_destroy();
        header("location: proallopathy.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
        exit();
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
    <style>
        .form-label
        {
            width: 200px;
        }
       
        .profile_photo
        {
            width: 300px;
            border:1px solid black;
            height: 300px;
            /* border-radius: 50%; */
        }
        .profile_photo img{
            width: 100px;
           height: 100px;
           border-radius: 50%;
           
        }
        /* .flex
        {
            display: flex;
        } */
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="navbar">
        <?php
        include_once('navbar.php');
        ?>
    </div>
    <br><br><br>
    <div class="container" style="width:900px;">
        <div class="row">
            <div class="col-lg-12 text-center border rounded">
                <h1>Profile</h1>
            </div>
            <div class="col">
        <div class="profile">
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            
            <div class="profile-data mt-5">
                <div class="mb-3 d-flex">
                    <label  class="form-label mx-4">Name</label>
                    <input type="text" class="form-control mx-4" name="name" value="<?php echo $user['name']; ?>" required>
                </div>
                <div class="mb-3 d-flex">
                    <label  class="form-label mx-4">Username</label>
                    <input type="text" class="form-control mx-4" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="mb-3 d-flex">
                    <label  class="form-label mx-4">Email</label>
                    <input type="text" class="form-control mx-4" name="email" value="<?php echo $user['email']; ?>" >
                </div>
                <div class="mb-3 d-flex">
                    <label  class="form-label mx-4">Phone</label>
                    <input type="text" class="form-control mx-4" name="contactno" value="<?php echo $user['contactno']; ?>" required>
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <label style="color:red; margin-bottom: 0px;"><?php echo $error; ?></label>
                </div>
                <div class="d-flex">
                    <button class="btn btn-primary w-50 mx-4" name="upd_btn">Update profile</button>
                    <button class="btn btn-primary w-50 mx-4" name="delete_btn">Delete profile</button>
                </div>
                
            </div>
            
        </div>
        <br>
        <div class="pro_display text-center">
            <a href="orderhistory.php" class="btn btn-primary w-50 mt-3">Orders</a><br>
        </div>
            </div>
            </div>

        
    </div>
</body>
</html>