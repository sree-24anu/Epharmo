<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epharmosys</title>
    <link href="sty.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="navbar">
        <?php
        include_once('navbar.php');
        ?>
    </div>
    <div class="container content">
        <div class="row">
            <div class="col-lg-12 text-center border rounded my-5">
                <h1>Cart</h1>
            </div>

           <?php
           if ((isset($_SESSION['cart'])) && (count($_SESSION['cart'])>=1))
           {
            
            echo'<div class="col-lg-8">';
                
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $key => $value) {
                        $prod_id=$value['prod_id'];
                        $qty=mysqli_query($conn,"select * from stocks where id='$prod_id';");
                        $row=mysqli_fetch_assoc($qty);
                        $qtyno=($row['qty'] <= 10) ? $row['qty'] : '20';
                        echo "<div class='cart'>
                                <div class='image'>
                                    <img src='images/$value[img]'>
                                </div>
                                <div class='cartdetails w-100' style='padding-top: 0;'>
                                    <h3>$value[Itemname]</h3>

                                    
                                    <p>Rs.$value[price]</p>
                                    <input type='hidden' class='sub_price' value='$value[price]'></td>

                                    <div class='bottom'>
                                        <div class='btmleft'>
                                            <form action='insertintocart.php' method='post'>
                                                <input class='text-center sub_quantity' name='quantity' onchange='this.form.submit();' type='number' min='1' max = '$qtyno' value='$value[Quantity]'>
                                                <input type='hidden' name='itemname' value='$value[Itemname]'>
                                            </form>
                                            <form action='insertintocart.php' method='post'>
                                                <button class='btn btn-sm btn-outline-danger mx-2' name='remove_item'>Remove</button>
                                                <input type='hidden' name='itemname' value='$value[Itemname]'>
                                            </form>
                                        </div>
                                        <div class='btmright'>
                                            <h5>Subtotal:</h5>&nbsp;
                                            <h5 class='sub_total'>  </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                } 
                ?>

            </div>
            <div class="col-lg-4">
                <div class="border bg-light rounded p-4">
                 <?php $items=count($_SESSION['cart']); ?>
                    <h4>Total</h4>
                    <div class="total">
                        <h5>Items : </h5>
                        <h5> <?= $items ?> </h5>
                    </div>
                    <div class="total">
                        <h5>Total price : <h5 class="text-center" id="total"> </h5>
                        </h5>
                    </div>
                   
                    <a href="proceed.php" class="btn btn-primary w-100">Proceed </a>
                    

                </div>

            </div>

            <?php 
            }
            else
            {
                echo '<h4 class="text-center">Your cart is empty</h4>';
            }
            ?>
        </div>
    </div>

    <script>
        let sub_price = document.getElementsByClassName('sub_price');
        let sub_quantity = document.getElementsByClassName('sub_quantity');
        let sub_total = document.getElementsByClassName('sub_total');
        let total = document.getElementById('total');
        let gtotal = 0;
        function subtotal() {
            gtotal = 0;
            for (i = 0; i < sub_price.length; i++) {
                sub_total[i].innerText ="Rs. "+(sub_price[i].value) * (sub_quantity[i].value);
                gtotal = gtotal + (sub_price[i].value) * (sub_quantity[i].value);
                // console.log(qty);
            }
            total.innerText = "Rs. "+gtotal;
        }
        subtotal();
    </script>
        
</body>

</html>