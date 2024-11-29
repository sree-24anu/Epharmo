<?php
include_once ('connection.php');
$loginerror = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username != '' && $password != '') {

      $query = "SELECT * FROM admin_login WHERE username = '$username' AND password = '$password'";
      $result = mysqli_query($conn, $query);
      $num = mysqli_num_rows($result);
      if ($num == 1) {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['adminid'] = $row['id'];
        header("location: dashboard.php");
      } else {
        $loginerror = "Invalid username or password";
      }

    }
    else 
    {
      $loginerror="Please enter username and password!!";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
    integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
<style>
body {
  background-image: url('../usage/images/image2.jpeg');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
}

 </style> 
</head>

<body>
  <?php
   include_once ('nav.php');
  ?>

  <div class="login_container">

    <div id="login-form" class="login_card m-auto p-2">
      <div class="card-body">

        <form name="login-form" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
          method="post">
          <div class="logo">
            <img src="../usage/images/admin.png" class="profile" />
            <h1 class="logo-caption"><span class="tweak"></span>Login</h1>
          </div>
          <?php
          if ($loginerror) {
            echo '<p class="h6 text-center text-light">'.$loginerror.' <p>';
          }
          ?>
          <br>
          
          <div class="input-group login-form-group">
            <span class="input-group-text"><i class="fas fa-user text-white"></i></span>
            <input name="username" type="text" class="login-form-control" placeholder="username" required
              style="width: 80%; height: 40px; text-align: center;">
          </div>
          <div class="input-group login-form-group">
            <span class="input-group-text"><i class="fas fa-key text-white"></i></span>
            <input name="password" type="password" class="login-form-control" placeholder="password" required
              style="width: 80%; height: 40px; text-align: center;">
          </div>
          <br>
          <div class="login-form-group">
            <button class="btn btn-default btn-block btn-custom" type="submit" name="login">Login</button>
          </div>
        </form>

      </div>
    </div>
  </div>

</body>

</html>