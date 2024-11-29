<?php
session_start();
// session_destroy();
include_once('admin/connection.php');
if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(isset($_POST['addtocart']))
    {
        if(isset($_SESSION['cart']))
        {
            $myitems=array_column($_SESSION['cart'],'Itemname');
            if(in_array($_POST['name'],$myitems))
            {
                // print_r($_SESSION['cart']);
                echo "<script>alert ('item already present');
            window.location.href='cart.php';
            </script>'";
            }
            else
            {
            $count=count($_SESSION['cart']);
            $_SESSION['cart'][$count]=array('prod_id'=>$_POST['pro_id'],'Itemname'=>$_POST['name'],'price'=>$_POST['price'],'Quantity'=>1,'img'=>$_POST['img'],'page_return'=>$_POST['page_return']);
            // print_r($_SESSION['cart']);
            
            foreach($_SESSION['cart'] as $key => $value)
        {
 
            if($value['page_return'] == "Allopathy")
            {
                header('location:proallopathy.php');
                
            }
            else if($value['page_return'] == "Ayurveda")
            {
                header('location:proayurvedh.php');
               
            }
            else
            {
                header('location:'.$value['page_return'].'');
            }
            

         }
            } 

        }
        else
        {
            $_SESSION['cart'][0]=array('prod_id'=>$_POST['pro_id'],'Itemname'=>$_POST['name'],'price'=>$_POST['price'],'Quantity'=>1,'img'=>$_POST['img'],'page_return'=>$_POST['page_return']);
            // print_r($_SESSION['cart']);
            foreach($_SESSION['cart'] as $key => $value)
        {
 
            if($value['page_return'] == "Allopathy")
            {
                header('location:proallopathy.php');
            }
            else if($value['page_return'] == "Ayurveda")
            {
                header('location:proayurvedh.php');
               
            }
            else
            {
                header('location:'.$value['page_return'].'');
            }

         }
           
        

        }
    }
    if(isset($_POST['remove_item']))
    {
        foreach($_SESSION['cart'] as $key => $value)
        {
            if($value['Itemname']==$_POST['itemname'])
            {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart']=array_values($_SESSION['cart']);
            header('location:cart.php');
            }
        }
    }
    if(isset($_POST['quantity']))
    {
        foreach($_SESSION['cart'] as $key => $value)
        {
            if($value['Itemname']==$_POST['itemname'])
            {
                $_SESSION['cart'][$key]['Quantity']=$_POST['quantity'];
                // print_r($_SESSION['cart']);
            
            echo "<script>
            window.location.href='cart.php';
            </script>'";
            }
        }
    }

    if(isset($_POST['add_address']))
    {
        $name=$_POST['name'];
        $phoneno=$_POST['phone'];
        $address=$_POST['address'];
        
            $sqlcheck=mysqli_query($conn,"select * from `address` where `address`='$address'");
            if(mysqli_num_rows($sqlcheck)==0)
            {   
                $addquery="INSERT INTO `address`(`user_name`, `phoneno`, `address`) VALUES ('$name','$phoneno','$address')";
                $result = mysqli_query($conn, $addquery);
                if($result)
                {
                    header('location:proceed.php');
                }
            }
            header('location:proceed.php');
        }
        
    

    if(isset($_POST['edit_address']))
    {
            $add_id=$_POST['add_id'];
            $editquery="Update `address` set `user_name` = '$_POST[name]', `phoneno` = '$_POST[phone]', `address` = '$_POST[address]' where `add_id`='$add_id'";
            $result = mysqli_query($conn, $editquery);
            header('location:proceed.php');
       
    }

    if(isset($_POST['orderbtn']))
    {
            $order_id="24INVORD-".rand(111,999);
            $add_id=$_POST['add_id'];
            // echo $id;
            $total=$_POST['gtotal'];
            $user_id= $_SESSION['user_id'];

            $sqlcheck=mysqli_query($conn,"select * from `address` where `add_id`='$add_id'");
            $row=mysqli_fetch_assoc($sqlcheck);

            $order_add=mysqli_query($conn, "INSERT INTO `order_address`(`id`,`order_id`,`add_id`,`user_id`,`user_name`, `phoneno`, `address`, `order_date`, `total`, `status`) 
            VALUES ('','$order_id','$row[add_id]','$user_id','$row[user_name]','$row[phoneno]','address',NOW(),'$total','Processing');");

            // $order_id=mysqli_insert_id($conn);


            $orderquery="INSERT INTO `cart`(`order_id`,`add_id`,`prod_id`,`user_id`, `name`,`qty`, `price`, `image`) VALUES (?,?,?,?,?,?,?,?)";
            $prepared=mysqli_prepare($conn,$orderquery);
            if($prepared)
            {
                mysqli_stmt_bind_param($prepared,"siiisiis",$order_id,$add_id,$prod_id,$user_id,$itemname,$qty,$price,$image);
                foreach($_SESSION['cart'] as $key => $values)
                {
                    $prod_id=$values['prod_id'];
                    $itemname=$values['Itemname'];
                    $qty=$values['Quantity'];
                    $price=$values['price'];
                    $image=$values['img'];
                    mysqli_stmt_execute($prepared);
                }
                // unset($_SESSION['cart']);
                if (mysqli_affected_rows($conn) > 0) {
                    // Cart insertion was successful
                    // echo "success";
                    $_SESSION['order_success'] = true;
                    header('location:proceed.php');

                } else {
                    // Cart insertion failed
                    // echo "cart insertion failed";
                    $_SESSION['order_failed'] = true;
                    header('location:proceed.php');
                }
                // header('location:successfull.php');
            }
            else
            {
                echo 'prepare error';
            }
            
    }  
    
    if (isset($_POST['submit_review'])) {
        $name = $_POST['name'];
        $rating = $_POST['rating'];
        $content = $_POST['content'];

        // Insert a new review 
        $insert_review = mysqli_query($conn, "INSERT INTO reviews (user_id, name, content, rating, submit_date) VALUES ('$_SESSION[user_id]','$name','$content','$rating',NOW());");
        header('location:examplereview.php');
    } 
    
    
    if (isset($_POST['review_delete'])) {
        $review_id = $_POST['review_id'];
        

        // Insert a new review 
        $delete_review = mysqli_query($conn, "DELETE FROM `reviews` where `review_id`='$review_id';");
        header('location:examplereview.php');
    } 
}


if(isset($_REQUEST['aid']))
    {
        $id=$_REQUEST['aid'];
        $delquery=mysqli_query($conn,"DELETE FROM `address` WHERE `add_id`='$id'");
        header('location:proceed.php');
    }
    else
    {
        echo 'id not set';
    }

?>