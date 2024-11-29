<?php
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'admin/connection.php';
if(isset($_POST['login']))
{
    $username = trim(mysqli_real_escape_string($conn,$_POST['username']));
    $password = trim(mysqli_real_escape_string($conn,$_POST['password']));
    if ($username != '' && $password != '') {
        $sql = "SELECT * FROM user_login WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];
            header("location: home.php");
        } else {
            $error = "Username or password is invalid";
        }
    } else {
        $error = "Please enter username and password!!";
    }
}
}
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
    <link href="sty.css" rel="stylesheet">
</head>

<body>
    <?php
        include_once ('nav.php');
    ?>

    <div class="login_container">
        <h2>Login</h2>
        <!-- <div id="login-form" class="login_card m-auto p-2">
      <div class="card-body"> -->
        <br>
        <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="error">
                    <?php echo $error; ?>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" value="Login">
                </div>
                <div class="error">
                    <?php 
                    if($error)
                    {
                        echo '<a href="check_email.php" style="color:red;">Forget password?</a>';
                    }
                    ?>
                </div>
                <div class="footer text-center">
                    <p>Don't have an account?</p><a href="sigin.php">Signup</a>
                </div>
                <br>
            </form>
        </div>
    </div>

</body>

</html>