<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Login</title>
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
    

<?php  if(!isset($_SESSION['success']))
        { ?>
    <div class="login_container">
        <h2>Enter your Registered email</h2>
        <!-- <div id="login-form" class="login_card m-auto p-2">
      <div class="card-body"> -->
        <br>
        <div class="card-body">
            <form method="post" action="reset.php">
                <div class="error">
                    <?php  if(isset($_SESSION['error_msg']))
                    {
                        echo $_SESSION['error_msg']; 
                    }
                    if(!isset($_POST['verify']))
                    {
                        unset($_SESSION['error_msg']);
                    }    ?>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" >
                </div>
                
                <div class="form-group">
                    <input type="submit" name="verify" value="Verify">
                </div>
                <div class="footer text-center">
                <?php  if(isset($_SESSION['success']))
                    {
                        echo $_SESSION['success'];
                    }
                    if(!isset($_POST['verify']))
                    {
                        unset($_SESSION['success']);
                    }    ?>
                    
                </div>
                <br>
            </form>
        </div>
    </div>
               <?php }?>



    <?php  if(isset($_SESSION['success']))
        { ?>
    <div class="login_container">
        <h2>Enter OTP</h2>
        
        <br>
        <div class="card-body">
            <form method="post" action="reset.php">
                <div class="error">
                    
                </div>
                <div class="form-group">
                    <label>Otp:</label>
                    <input type="text" name="otp_value" >
                </div>
                
                <div class="form-group">
                    <input type="submit" name="otp_verify" value="Verify">
                </div>
                <div class="footer text-center">
                <?php  if(isset($_SESSION['success']))
                    {
                        echo $_SESSION['success'];
                    }
                    if(!isset($_POST['verify']))
                    {
                        unset($_SESSION['success']);
                    }    ?>
                    
                </div>
                <br>
            </form>
        </div>
    </div>
    <?php }?>
 
</body>

</html>