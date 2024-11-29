<?php
session_start();
include_once('admin/connection.php');
$msg = "";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    $_SESSION['loggedin'] = false;
    $_SESSION['user_id'] = false;
    
    header("location: login.php");
    exit();

} else {
    $msg = true;
    $user_id=$_SESSION['user_id'];
}
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
    <section class="content">
    <?php
           if ((isset($_SESSION['cart'])) && (count($_SESSION['cart'])>=1))
           { ?>
        <div class="row">
            <div class="col-lg-7">
            
                <div class="order">
                    <h3>Address</h3>
                    <?php
                    include_once('admin/connection.php');
                    $query1 = mysqli_query($conn, "Select * from `address`");
                    if(mysqli_num_rows($query1)>=1)
                    {
                    while ($row = mysqli_fetch_assoc($query1)) {
                    if($row['user_id']==$_SESSION['user_id']) {
                        echo '<div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="' . $row['add_id'] . '" value="' . $row['add_id'] . '">
                                <label class="form-check-label" for="' . $row['add_id'] . '">
                                ' . $row['user_name'] . ' <br>
                                ' . $row['address'] . ' <br>
                                ' . $row['phoneno'] . '
                                <br>
                                <div class="' . $row['add_id'] . ' buttons">
                                    <a href="proceed.php?id=' . $row['add_id'] . '">Edit</a> 
                                    |
                                    <a href="insertintocart.php?aid=' . $row['add_id'] . '" name="deletebtn">Delete</a>
                                            
                                    <br>
                                    <form action="#" method="post">
                                        <button class="btn btn-primary cnf_btn" type="submit" name="add_address" onclick="this.form.submit();">Confirm</button>
                                        <input type="hidden" name="display_add_id" value="' . $row['add_id'] . '">
                                    </form>
                                </div>
                            </label>
                        </div>
                        <br>';
                    }
                }
            }
            else
            {
               echo '<form action="#" method="post">
               <button class="btn btn-primary cnf_btn" type="submit" name="add_address" onclick="this.form.submit();">Confirm</button>
               <input type="hidden" name="display_add_id" value="' . $row['add_id'] . '">
           </form>';
            }
                
                    ?>

                    <button class="btn btn-primary address">Add another address</button>
                </div>


                <div class="payment">
                    <h3>Payment Mode</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadio" id="payment_mode" checked>
                        <label class="form-check-label" for="payment_mode">
                            Cash on Delivery
                        </label>
                    </div>
                </div>

            </div>
            <div class="col-lg-5">

                <div class="shipment">
                    <div class="addaddress">
                        <h3>Add address</h3>
                        <form action="insertintocart.php" method="post" id="add_address_form">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" id="address_name" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone no</label>
                                <input type="text" id="address_phoneno" class="form-control" name="phone"min="10" max="10" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" id="address" col="2" name="address" required></textarea>
                            </div>
                            
                            <p class="text-center" id="address_empty" style="color:red;"></p>
                                   
                            <button type="submit" class="btn btn-primary w-100" name="add_address">Add</button>
                        </form>
                    </div>

                    <div class="editaddress">
                        <?php
                        if(isset($_REQUEST['id']))
                        {
                            $id=$_REQUEST['id'];
                            $sqledit=mysqli_query($conn,"Select * from `address` where `add_id`='$id'");
                            $row=mysqli_fetch_assoc($sqledit);
                            echo '<div class="total"><h3>Edit address</h3></div>
                                    <form action="insertintocart.php" method="post" id="edit_address_form">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" id="edit_name" class="form-control" name="name" value="'. $row['user_name'] .'" required>
                                    </div>
                                    <div class="mb-3">
                                        <label  class="form-label">Phone no</label>
                                        <input type="text" id="edit_phoneno" class="form-control"  name="phone" value="'. $row['phoneno'] .'" min="10" max="10" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" id="edit_address" col="2" name="address" required>'. $row['address'] .'</textarea>
                                    </div>

                                    <p class="text-center" id="edit_address_empty" style="color:red;"></p>


                                    <input type="hidden" class="form-control"  name="add_id" value="'. $row['add_id'] .'">
                                    <button type="submit" class="btn btn-primary w-100" name="edit_address">Edit</button>
                                </form>';  
                        }
                        ?>
                    </div>
                </div>

                <div class="order">
                    <div class="border bg-light rounded p-4">
                        <h4>Total</h4>
                        
                        <?php
                        $gtotal=0;
                        $qty=count($_SESSION['cart']);
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $total = $value['Quantity'] * $value['price'];
                            $gtotal = $gtotal+$total;     
                        }
                        ?>

                        <div class="total">
                            <h5>Items : </h5>
                            <h5 id="qty"> <?php echo $qty; ?> </h5>
                        </div>
                        <div class="total">
                            <h5>Total price : </h5>
                            <h5 class="text-center" id="total">Rs. <?php  echo $gtotal; ?> </h5>
                        </div>
                        <div class="total">
                            <h5>Payment mode : </h5>
                            <h5> Cash on Delivery </h5>
                        </div>
                        <?php
                        if (isset($_POST['add_address'])) {
                            $id = $_POST['display_add_id'];
                            $add_query = mysqli_query($conn, "Select * from `address` where `add_id`='$id';");
                            $row = mysqli_fetch_assoc($add_query);
                            echo '<h5>Delever to:  ' . $row['user_name'] . ' <br>
                               ' . $row['address'] . '
                                <br>
                                phone no: ' . $row['phoneno'] . '
                                <br>
                            </h5>';
                            echo '<form action="insertintocart.php" method="post">
                                    <button class="btn btn-primary w-100" name="orderbtn" onclick="this.form.submit();"> Order </button>
                                    <input type="hidden" name="add_id" value="' . $row['add_id'] . '">
                                    <input type="hidden" name="gtotal" value="' . $gtotal . '">
                                    <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">

                                </form>';
                        }
                        ?>
                    </div>
                </div>
                <!-- </div> -->


            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="display">
                    <h3>Order</h3>
                    <?php
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $total = $value['Quantity'] * $value['price'];
                            echo "<div class='cart'>
                            <div class='image'>
                                <img src='images/$value[img]'>
                            </div>
                            <div class='cartdetail w-100'>
                            <h3>$value[Itemname]</h3>
                            <p>Price : Rs.$value[price]</p>
                                <p>Quantity : $value[Quantity]</p>
                                <p>Sub total : Rs.$total</p>
                            </div>
                        </div>";
                        }
                    } else {
                        echo "You have not ordered anything";
                    }

                    ?>
                </div>

            </div>
          
        </div>


        <?php 
            }
            else
            {
                echo '<h4 class="text-center" style="margin-top:250px; position:fixed; width:80%;">Your cart is empty to make an order</h4>';
            }
            ?>
    </section>

<!-- Success Modal -->
<div class="modal fade" data-bs-backdrop="static" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-body text-center">
                <img src="usage/images/order-icon.jpg" alt="order_successful" width="100px"><br><br>
                Your order has been placed successfully.
            </div>
            <div class="modal-footer">
                <a type="button" href="proallopathy.php" class="btn btn-secondary">Ok</a>
            </div>
        </div>
    </div>
</div>

<!-- Failure Modal -->
<div class="modal fade" id="orderFailureModal" tabindex="-1" aria-labelledby="orderFailureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderFailureModalLabel">Order Failed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sorry, there was an error processing your order. Please try again .
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>





    <script src="script.js"></script>
    <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function () {
            $('.form-check-input').click(function (e) {
                var buttons = "." + $(this).attr('value');
                $(buttons).toggle();
                
            });
           
            $('.address').click(function (e) {
                $('.addaddress').toggle();
                $('.editaddress').hide();
            });

            $('.editaddress').click(function (e) {
                $('.addaddress').hide();
            });
    
           
    });
    
   
    </script>

<script>
    
    setTimeout(function() {
        <?php if(isset($_SESSION['order_success']) && $_SESSION['order_success']): ?>
            
            var successModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
            successModal.show();
           
            <?php unset($_SESSION['order_success']);
            unset($_SESSION['cart']); ?>

        <?php elseif(isset($_SESSION['order_failed']) && $_SESSION['order_failed']): ?>
           
            var failureModal = new bootstrap.Modal(document.getElementById('orderFailureModal'));
            failureModal.show();
            
            <?php unset($_SESSION['order_failed']); ?>
        <?php endif; ?>
    }, 100);
</script>

</body>

</html>