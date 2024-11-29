<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: login.php");
    exit();
}
include_once("connection.php");
$error = false;
if (isset($_POST["upd_btn"])) {
    $username = trim(mysqli_real_escape_string($conn,$_POST["name"]));
    $old_pswd = trim(mysqli_real_escape_string($conn,$_POST["old_pswd"]));
    $new_pswd = trim(mysqli_real_escape_string($conn,$_POST["new_pswd"]));
    $cnf_pswd = trim(mysqli_real_escape_string($conn,$_POST["cnf_pswd"]));

    if ($username != '' && $old_pswd != '' && $new_pswd != '' && $cnf_pswd != '') {

    $check = mysqli_query($conn, "select * from admin_login where username='$username' and password='$old_pswd';");
    $numrows = mysqli_num_rows($check);
        if ($numrows <= 0) {
            $error = "Invalid user name or old password" ;
        } else {
            if($new_pswd == $cnf_pswd)
            {
                $update = mysqli_query($conn, "Update admin_login set password='$new_pswd';");
                $error="Updateded successfully";
            }
            else
            {
                $error="Password doesn't match";
            }
        }
    }
    else 
    {
      $error="Please fill all the fields!!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href='style.css' rel='stylesheet'>
    <style>
    


    </style>
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
            <div class="pswd">
                <h1>Reset Password</h1>
                <br>
                <div class="row">
                    <div class="col"></div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="inner_panel panel-default">
                            <div class="panel-heading">
                                <h4>Reset Password</h4>
                            </div>
                            <p class="h6 text-center text-danger">
                            <?php
                            if($error)
                            {
                                echo $error;
                            }
                            ?>
                            <p> 
                            <div class="panel-body form-group form-group-sm">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="name">User name </label>
                                            <input type="text" name="name" placeholder="Name" required>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="name">Old Password</label>
                                            <input type="password" name="old_pswd" placeholder="Enter password" required>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="name">New Password</label>
                                            <div class="column">
                                                <input type="password" name="new_pswd"  id="password" placeholder="Enter password" required>
                                                <div id="password-strength"></div>
                                                <progress id="password-strength-bar" max="100" value="0"></progress>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="name">Confirm Password </label>
                                            <input type="password" name="cnf_pswd" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p id="not_strong" class="text-center" style="color:red; margin-bottom: 0px;"></p>
                                    </div>
                                    <div class="button">
                                        <input type="submit" id="upd_btn" name="upd_btn" value="Update">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col"></div>

                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>