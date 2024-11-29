<?php

include_once('connection.php');
// Query 1: returns all the distincit ctegory whose quantity is 0 from stocks db
$stockquery = "SELECT DISTINCT * FROM `stocks` where `qty`<= 0";
$stockqueryres = mysqli_query($conn, $stockquery);
while ($row = mysqli_fetch_assoc($stockqueryres)) 
{

    // Query 2: returns all the data whose category value matches the above query value [i.e (Query 1) category value whose quantity is 0]
    $stock_cat = mysqli_query($conn, "Select * from stocks where category='$row[category]';");
    $row_of_stock_cat = mysqli_fetch_assoc($stock_cat);
    $noofrows_of_stock_cat = mysqli_num_rows($stock_cat);

    // if the number of rows of $stock_cat query(Query 2) is greater than 1
    if ($noofrows_of_stock_cat > 1) 
    {
        // Query 3: returns all the data whose category value matches the $stock_cat query (Query 2) and have quantity value 0
        $stock_catqty = mysqli_query($conn, "Select * from stocks where category='$row_of_stock_cat[category]' and qty<=0;");
        $noofrows_of_stock_catqty = mysqli_num_rows($stock_catqty);
        while ($row_of_stock_catqty = mysqli_fetch_assoc($stock_catqty)) 
        {
            // if number of rows of $stock_cat query(Query 2) = number of rows of $stock_catqty query(Query 3) [i.e ]
            if ($noofrows_of_stock_cat == $noofrows_of_stock_catqty) 
            {
                //Updates the status of category db to unavaliable 
                $sqlupdate = "UPDATE `categories` set  status='Unavaliable' WHERE cname='$row_of_stock_catqty[category]'";
                $sqlupdateres = mysqli_query($conn, $sqlupdate);                
            } 
                // check if the product is already present .... if it is not present insert into outofstock db 
                $sqlcheck = mysqli_query($conn, "SELECT * from outofstocks where name='$row_of_stock_catqty[genericname]';");
                if (mysqli_num_rows($sqlcheck) == 0) 
                {
                    $insertquery = mysqli_query($conn,"INSERT INTO `outofstocks`(`id`, `name`, `category`, `subcategory`, `price`) 
                    VALUES ('','$row_of_stock_catqty[genericname]','$row_of_stock_catqty[category]','$row_of_stock_catqty[sub_category]','$row_of_stock_catqty[price]');");
                }

                // delete the product from the stocks db
                $sqldelete=mysqli_query($conn,"Delete from stocks where id='$row_of_stock_catqty[id]';");
            
        }
    } 

    // if the number of rows of $stock_cat query(Query 2) is lesser than 1
    else 
    {

        // Updates the status of category db to unavaliable
        $sqlupdate = "UPDATE `categories` set  status='Unavaliable' WHERE cname='$row[category]'";
        $sqlupdateres = mysqli_query($conn, $sqlupdate);
        
        // check if the product is already present .... if it is not present insert into outofstock db 
        $sqlcheck = mysqli_query($conn, "SELECT * from outofstocks where name='$row_of_stock_cat[category]';");
        if (mysqli_num_rows($sqlcheck) == 0) 
        {
            $insertquery = mysqli_query($conn, "Insert into `outofstocks`(`id`, `name`, `category`, `subcategory`, `price`) 
            values('','$row_of_stock_cat[genericname]','$row_of_stock_cat[category]'),'$row_of_stock_catqty[sub_category]','$row_of_stock_catqty[price]');");
        }

            // delete the product from the stocks db
            $sqldelete=mysqli_query($conn,"Delete from stocks where id='$row[id]';");

    }
}

$page = $_REQUEST['page'];
echo $page;
if ($page) {
 header('location:viewcategories.php');
} else {
      header('location:viewstock.php');
}
// header('location:viewstock.php');






?>
