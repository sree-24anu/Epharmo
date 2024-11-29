<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Epharmosys</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <style>
        *
{
    margin:0;
    padding: 0;
    box-sizing:border-box;
    font-family: 'Times New Roman', Times, serif;
}

a
{
    text-decoration: none;
}

body{
    min-height: 100vh;
}

/* SIDEBAR */

.sidebar
{
    margin-top: 55px;
    background: #1b1a1b;
    width: 300px;
    height: 90vh;
    position:fixed;
    top:0;
    overflow-y:auto;
    transition: 0.6s ease;
    overflow-x: hidden;
    z-index: 1000;
}


/* menulist */

.menu
{
    width: 100%;
    margin-top: 15px;
}
.menu .items
{
    cursor:pointer;
}
.sub-menu
{
    display: block;
    background-color: #444747;
}

.items a:hover , .sub-menu a:hover
{
    background-color: #33363a;
}
.menu .items a{
    color: #fff;
    text-decoration: none;
    padding: 5px 20px;
    line-height: 60px;
    display: flex;
}

.sub-menu span
{
    padding: 5px 20px;
}

.items i
{
    margin-right: 15px;
    bottom: -18px;
    position: relative;
    padding-right: 15px;
}

.items .bx-chevron-right
{
    margin-left: auto;
    margin-right: 0%;
    width: 20px;
    height: 20px;
}

.sidebar-link.rotate > .bx-chevron-right
{
    transform: rotate(90deg);
}

.sidebar::-webkit-scrollbar
{
    width: 7px;
    background-color: #1b1a1b;
    border-radius: 10px;
}
.sidebar::-webkit-scrollbar-thumb
{
    background-color: #33363a;
    border-radius: 10px;

}

/* NAVBAR */

.nav
{
    width: 100%;
    height: 55px;
    background-color: #1b1a1b;
    color: #fff;
    padding:0 24px;
    align-items: center;
    top: 0;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    position: fixed;
    z-index: 1000;
}

 .nav h2
{
    margin-left: 15px;
    margin-top: 10px;
}

    </style>
</head>

<body>

    <div class="sidebar">

        <!-- menu list -->

        <div class="menu">

            <div class="items">
                <a href="dashboard.php" class="sidebar-link">
                    <i class='bx bxs-dashboard bx-sm'></i>Dashboard
                </a>
            </div>

            

            <div class="items">
            <a href="viewcategories.php" class="sidebar-link">
                    <i class='bx bx-category bx-sm'></i>Categories
                </a>
            </div>

            <div class="items">
            <a href="viewmanufacturer.php" class="sidebar-link">
                    <i class='bx bxs-user bx-sm'></i>Manufacture
                </a>
            </div>

            <div class="items">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#medicine"
                    aria-expanded="false" aria-controls="medicine">
                    <i class='bx bxs-capsule bx-sm'></i>Stocks
                    <i class='bx bx-chevron-right bx-sm'></i>
                </a>
                <!-- dropdown -->
                <div id="medicine" class="sub-menu collapse" data-bs-parent="#sidebar">
                    <a href="viewstock.php" class="subitem"><span>View Medicine</span></a>
                    <a href="viewexpiry.php" class="subitem"><span>Expired Medicine</span></a>
                    <a href="viewoutofstock.php" class="subitem"><span>out of stock</span></a>
                </div>
            </div>
            
            <div class="items">
                <a href="orders.php"><i class='bx bxs-package bx-sm'></i>Orders</a>
            </div>

            <div class="items">
            <a href="report.php" class="sidebar-link">
                    <i class='bx bxs-report bx-sm'></i>Report
                </a>
            </div>

            <div class="items">
                <a href="viewreviews.php"><i class='bx bxs-star bx-sm'></i>Reviews</a>
            </div>

            <div class="items">
                <a href="customers.php"><i class='bx bxs-user-account bx-sm'></i>Users</a>
            </div>

        </div>

        <div class="menu">
        <div class="items">
                <a href="reset_pswd.php"><i class='bx bxs-keyboard bx-sm'></i>Reset Password</a>
            </div>
            <div class="items">
                <a href="logout.php"><i class='bx bx-log-out bx-sm'></i>Logout</a>
            </div>

        </div>

    </div>

    <!-- NAVBAR -->

    <div class="nav">

        <h2 class="name">Epharmosys</h2>
        <div class="nav-items">
                <?php

                echo date("jS  F Y , l");

                ?>
        </div>
    </div>








    <script src="script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>