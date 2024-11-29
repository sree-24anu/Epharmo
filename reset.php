<?php
session_start();
$error_msg = '';

// $error = '';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


function sendemail_verify($email)
{
    $mail = new PHPMailer(true);

    //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();   
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                             //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->Username   = 'epharmo2000@gmail.com';                     //SMTP username
    $mail->Password   = 'wtpi wmej gkuf ajjq';                //SMTP password

    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;     

    $mail->setFrom('epharmo2000@gmail.com', 'Epharmosys');
    $mail->addAddress($email);     //Add a recipient

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'OTP for resetting password';
    $email_demo = '<h4> Your otp is '.$_SESSION['otp'].'</h4>';
    $mail->Body    = $email_demo;
    
    $mail->send();
    // echo 'Message has been sent';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'admin/connection.php';

    

    if(isset($_POST['verify']))
    {
        $email = $_POST['email'];
        $sql="SELECT * FROM user_login where `email`='$email';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email_user_id']=$row['id'];

        if($email != '')
        {
            $_SESSION['otp'] = rand(1111,9999);
            $sql = "SELECT * FROM user_login WHERE email='$email'";
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
                // $error_msg ="success";
                

                sendemail_verify("$email");
                
                // $_SESSION['error_msg'] = $_SESSION['otp'];
                $_SESSION['success'] = "You will receive an otp soon....!!Please wait";
                header('location:check_email.php');
            }
            else
            {
                $_SESSION['error_msg'] ="The email is not registered !! Please enter your registered email address";
                header('location:check_email.php');

            }
        
        }
        else
        {
            $_SESSION['error_msg'] ="Enter an email id";
            header('location:check_email.php');

        }


    }

    if(isset($_POST['otp_verify']))
    {
        $otp = $_POST['otp_value'];
  
            if($otp == $_SESSION['otp'])
            { 
                unset($_SESSION['otp']);
                $_SESSION['change_password'] = true;
                header('location:reset_user_psswd.php');
            }
            else
            {
            $_SESSION['success'] ='Wrong OTP';
            header('location:check_email.php');

            }
    }


    if(isset($_POST['reset_psswd']))
    {
        $password = $_POST['psswd'];
        $cpassword = $_POST['cnf_psswd'];

        if($password != '' && $cpassword != '')
        { 
            if ($password != $cpassword) {
                $_SESSION['psswd_match_err'] = "Passwords do not match";
                header('location:reset_user_psswd.php');

            } else {
                $sql=mysqli_query($conn,"UPDATE `user_login` set `password`='$password' where `id`='$_SESSION[email_user_id]' ;");
                unset($_SESSION['change_password']);
                header('location:login.php');
            }
        }
        else
        {
            $_SESSION['txt_empty'] = "Fill both the input field";
            header('location:reset_user_psswd.php');
        }
    }


    // reset_psswd
}
?>