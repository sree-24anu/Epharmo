<?php
session_start();

require_once 'vendor/autoload.php';

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'admin/connection.php';

    $name = trim(mysqli_real_escape_string($conn,$_POST['name']));
    $username = trim(mysqli_real_escape_string($conn,$_POST['username']));
    $email = trim(mysqli_real_escape_string($conn,$_POST['email']));
    $contactno = trim(mysqli_real_escape_string($conn,$_POST['contactno']));
    $password = trim(mysqli_real_escape_string($conn,$_POST['password']));
    $confirm_password = trim(mysqli_real_escape_string($conn,$_POST['confirm_password']));

    if ($name != '' && $username != '' && $email != '' && $contactno != '' && $password != '' && $confirm_password != '') {
        // phone number validation
        $phonepattern = '/^[0-9]{10,10}$/';
        if (preg_match($phonepattern, $contactno) && $contactno[0] >= 6) {
            // email validation
            $validator = new EmailValidator();
            $isValid = $validator->isValid($email, new DNSCheckValidation());

            $domain = substr(strchr($email, '@'), 1);
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && ($isValid)) {

                // conform password validation
                if ($password !== $confirm_password) {
                    $error = "Passwords do not match";
                } else {
                    // email and username already exists validation
                    $check_username = "SELECT * FROM user_login WHERE username='$username'";
                    $check_email = "SELECT * FROM user_login WHERE email='$email'";
                    $result_username = mysqli_query($conn, $check_username);
                    $result_email = mysqli_query($conn, $check_email);

                    if (mysqli_num_rows($result_username) > 0) {
                        $error = "Username already exists";
                    } else if (mysqli_num_rows($result_email) > 0) {
                        $error = "Email already exists";
                    } else {
                        $sql = "INSERT INTO user_login (name, username, email, contactno, password) VALUES ('$name', '$username', '$email', '$contactno', '$password')";
                        if (mysqli_query($conn, $sql)) {
                            $_SESSION['loggedin'] = true;
                            $_SESSION['user_id'] = mysqli_insert_id($conn);
                            header("location: home.php");

                            exit();
                        } else {
                            $error = "Error: " . mysqli_error($conn);
                        }
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







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="signin.css">
    
</head>

<body>

    <div class="register-container">
        <h2>Create An New Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="error"><?php echo $error; ?></div>
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="contactno">Contact No:</label>
                <input type="text" name="contactno" id="contactno" maxlength="10" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <div id="password-strength"></div>
                <progress id="password-strength-bar" max="100" value="0"></progress>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <div class="form-group">
                <label id="not_strong" class="text-center" style="color:red; margin-bottom: 0px;"></label>
            </div>
            <div class="form-group">
                <button type="submit" id="sign-up-btn">Sign Up</button>
            </div>
            <div class="footer text-center">
                <p>Already have an account?</p> <a href="login.php">Login</a>
            </div>
        </form>
    </div>

    <script>
        var passwordInput = document.getElementById("password");
        var strengthText = document.getElementById("password-strength");
        var strengthBar = document.getElementById("password-strength-bar");
        let button = document.getElementById("sign-up-btn");
        let alert_error = document.getElementById("not_strong");

        passwordInput.addEventListener("input", function () {
            var password = passwordInput.value;
            var strength = 0;

            // Check length
            if (password.length >= 6) {
                strength += 30;
            }

            // Check IF IT CONTAINS CAPITAL LETTER
            if (/[A-Z]/.test(password)) {
                strength += 30;
            }

            // Check if contains numbers
            if (/\d/.test(password)) {
                strength += 40;
            }

            // Update strength indicator
            if (strength <= 40) {
                strengthText.textContent = "Weak";
                strengthText.style.color = "#ff0000"; // Red
            } else if (strength <= 80) {
                strengthText.textContent = "Medium";
                strengthText.style.color = "#ffa500"; // Orange
            } else {
                strengthText.textContent = "Strong";
                strengthText.style.color = "#008000"; // Green
            }

            //strength does not exceed maximum value
            strength = Math.min(strength, 100);

            strengthBar.value = strength;

            strengthBar.style.display = "block";

            if (strengthText.textContent == "Weak") {
                button.disabled = true;
                button.style.backgroundColor = "grey";
                alert_error.textContent = "Enter stronger password!!";
            }
            else {
                button.disabled = false;
                button.style.backgroundColor = "";
                alert_error.textContent = "";
            }
        });

    </script>
</body>

</html>