<?php
    session_start();
    // echo $_SESSION['otp'];
    // echo $_SESSION['txt_empty'];
    if (!isset($_SESSION['change_password']) || $_SESSION['change_password'] != true)
    {
        header("location: check_email.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href="sty.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <style>
        body {
            background-image: url('usage/images/loginbg.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>


        <div class="login_container">
        <h2>Reset password </h2>
        <!-- <div id="login-form" class="login_card m-auto p-2">
      <div class="card-body"> -->

        <div class="card-body">
            <form method="post" action="reset.php">
                <div class="error">
                    <?php
                    if(isset($_SESSION['txt_empty']))
                    {
                        // unset($_SESSION['psswd_match_err']);
                        echo $_SESSION['txt_empty'];
                    }
                    if(isset($_SESSION['psswd_match_err']))
                    {
                        echo $_SESSION['psswd_match_err'];
                        // unset($_SESSION['txt_empty']);

                    }
                    if(!isset($_POST['reset_psswd']))
                    {
                        unset($_SESSION['txt_empty']);
                        unset($_SESSION['psswd_match_err']);
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="text" name="psswd" >
                </div>
                <div class="form-group">
                    <label>Confirm Password:</label>
                    <input type="text" name="cnf_psswd" >
                </div>

                <div class="form-group">
                    <input type="submit" name="reset_psswd" value="Reset password">
                </div>

                <br>
            </form>
        </div>
            </div>
            <?php

        //  unset($_SESSION['otp']);
        // echo $_SESSION['otp'];


        
?>

        
    </body>
</html>