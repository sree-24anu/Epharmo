<?php
session_start();
include_once ('admin/connection.php');
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    $_SESSION['loggedin'] = false;
    $_SESSION['user_id'] = false;
    $msg = false;
} else {
    $msg = true;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <title>Epharmosys</title>
    <link href="st.css" rel="stylesheet" type="text/css">
    <link href="reviews.css" rel="stylesheet" type="text/css">
</head>

<style>
    .review {
        margin-top: 10px;
    }

    .totals {
        display: flex;
        justify-content: space-between;
    }

    .buttons {
        align-content: center;
    }
</style>

<body>
    <?php
    include_once ('admin/connection.php');
    include_once ('navbar.php');
    ?>


    <div class="container review">
        <div class="navtop">
            <h1>Feedback</h1>
        </div>
        <div class="container">
            <h4>Give us a feedback and checkout the review by others</h4>

            <div class="reviews">

                <a href="#" class="write_review_btn">Write Review</a>


                <?php
                $overall_rating = mysqli_query($conn, "SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_reviews FROM reviews;");

                $overall_info = mysqli_fetch_assoc($overall_rating);
                // echo $overall_info['overall_rating'];
                // echo $overall_info['total_reviews'];
                
                ?>
                <div class="overall_rating">
                    <span
                        class="num"><?php echo isset($overall_info['overall_rating']) ? number_format($overall_info['overall_rating'], 1) : 'No reviews' ?></span>
                    <span
                        class="stars"><?php echo str_repeat('&#9733;', round($overall_info['overall_rating'])) ?></span>
                    <span class="total"><?php echo $overall_info['total_reviews'] . ' reviews' ?></span>
                </div>




                <?php
                if ($msg) {
                if (isset($_SESSION['loggedin'])) {
                    echo ' <div class="write_review">
                            <form id="review_form" method="POST" action="insertintocart.php">
                                <input name="name" type="text" id="review_name" placeholder="Your Name" >
                                <input name="rating" type="number" min="1" max="5" id="review_rating" placeholder="Rating (1-5)" >
                                <textarea name="content" id="review_content" placeholder="Write your review here..." ></textarea>
                                <br><br>
                                <p id="review_empty" style="color:red;"></p>
                                <button type="submit" name="submit_review">Submit Review</button>
                            </form>
                        </div>   ';
                       }
                }
                if (!$msg) {
                    echo '<div class="write_review">You need to login first to write a review</div>';
                    }
                

                ?>



                <?php
                $reviewquery = mysqli_query($conn, 'SELECT * FROM reviews ORDER BY submit_date DESC');
                while ($reviews = mysqli_fetch_assoc($reviewquery)) {
                    $stars = str_repeat('&#9733;', $reviews['rating']);

                    echo '       <div class="totals">
                    <div class="review">
                <h3 class="name">' . $reviews['name'] . ' </h3>
                <div>
                    <span class="rating">' . $stars . ' </span> 
                </div>
                <p class="content"> ' . $reviews['content'] . '</p>
                </div>
                <div class="buttons">';
                if ($msg) {
                    if ($reviews['user_id'] == $_SESSION['user_id']) {
                        echo '<div class="review">
                    <form method="POST" action="insertintocart.php">
                    <input type="hidden" name="review_id" value="' . $reviews['review_id'] . '">
                    <button type="submit" class="btn btn-danger" name="review_delete">Delete</a></div>
                    </form>';
                    }
                }
                    echo '</div>
                    </div>
                <hr>

                ';
                } ?>
            </div>

        </div>

        <script src="http://localhost/project/usage/jquery-3.7.1.js"></script>
        <script>

            $(document).ready(function () {
                $('.write_review_btn').click(function (e) {

                    e.preventDefault();
                    $('.write_review').toggle();
                });

            });
            document.getElementById("review_form").addEventListener("submit", function(event) 
            {
            
            let name = document.getElementById("review_name").value;
            let rating = document.getElementById("review_rating").value;
            let content = document.getElementById("review_content").value;
            let view_alert = document.getElementById("review_empty");

                if(name.trim()=='' || rating.trim()=='' || content.trim()=='')
                {
                    event.preventDefault();
                    view_alert.innerText = "Please fill all the fields!!";
                }
                else
                {
                    document.getElementById("review_form").submit();
                    view_alert.innerText = "";
                }
            });
        </script>
    </div>




    </div>
</body>

</html>