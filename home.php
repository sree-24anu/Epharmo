<?php
session_start();
$msg = "";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = false;
} else {
    $msg = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .home {
            margin-top: 50px;
            width: 100%;
            height: 100vh;
            background-image: url('usage/images/backgroundimg.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: right;
            position: fixed;
        }

        h1 {
            color: #F3F3F3;
            /* font-size: 140px; */
            margin-top: 0px;
            margin-left: 0px;
            font-family: Vivaldi;
            /* Constantia; */
            font-weight: normal;
            font-size: 50px;
        }
        p {
            /* color: #F3F3F3; */
            font-size: 140px;
            margin-top: 0px;
            margin-left: 0px;
            font-family: Vivaldi;
            /* Constantia; */
            font-weight: normal;
            font-size: 30px;
        }
    </style>
</head>

<body>

    <?php
    require_once 'navbar.php';
    ?>
    <div class="home">
        <div style="margin-top:250px;" >
        <h1 >Welcome to Epharmosys<h1>
            <p> Your one-stop destination for all your healthcare needs </p>
        </div>
        
    </div>
</body>
</html>