<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
    * {
        text-decoration: none;
        margin: 0;
        padding: 0;
        font-family: 'Times New Roman', Times, serif;
    }


    .navbar {
        top: 0;
        /* padding-left: 15px;
        padding-right: 15px; */
        /* margin-top: 24px; */
        margin-top: 0;
        background-color: #2fa4cb;
        width: 100%;
        /* height: 60px; */
        position: fixed;
        z-index: 100;
        height: 50px;
    }

    .navdiv {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-left: 10px;
    }

    /* .nav-logo {
        color: whitesmoke;
    } */

    .navbar li {
        list-style: none;
        display: inline-block;
        text-align: center;
        padding: 5px;
    }

    .navbar li a {
        margin-right: 25px;
        /* color: whitesmoke; */
        color: black;
        text-decoration: none;
    }

    .navbar button a {
        padding: 0px;
        margin-left: 5px;
        margin-right: 5px;
    }

    .navbar-collapse {
        background-color: #2fa4cb;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    .show li:hover {
        /* background-color: #37bfeb; */
        background-color: #33b1db;
        /* background-color: #4cb7db; */
        /* background-color: #4099b7; */
    }
    /* .admin_nav
    {
        justify-content: end;
    display: flex;
    width: 100%; */
    /* background-color: ; */
    /* background-color: #487a8b;
    height: 24px;
    
    }
    .admin_nav p
    {
        font-size: larger;
    font-family: 'Times New Roman', Times, serif;
    width: 12%;
    }  */
</style>

<body>
<!-- <div class="admin_nav">
    <p>Admin</p>
    </div> -->
    <?php
    include_once ('admin/connection.php');
    // include_once ('nav.php');

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $loggedin = true;
    } else {
        $loggedin = false;
    }
    echo '
    <nav class="navbar navbar-expand-lg">
        <div class="navdiv">
            <div class="nav-logo">
                <h2>Epharmosys</h2>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="proallopathy.php">Product</a></li>

                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="examplereview.php">Review</a></li>';


    if (!$loggedin) {
        echo '  
                        <li><a href="login.php">Login</a></li> ';
    }

    if ($loggedin) {

        echo '    <li><a href="profile.php">Profile</a></li>

                    <li><a href="logout.php">Logout</a></li>';
    }
    echo '  

                </ul>
            </div>
    </nav>';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>