<?php
$sername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacy";
$conn = mysqli_connect($sername, $username, $password, $dbname);
if ($conn) {
    echo " ";
} else {
    die("Connection not established" . mysqli_error($conn));
}
?>