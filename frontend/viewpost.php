<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="js/nav_footer.js"></script>
</head>
<body>
<div id="nav-content"></div>
<?php
// Check if the 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    // Retrieve the value of the 'id' parameter
    include("../db_cofnfiguration/config.php");

    function calculateAverageRating($productid, $conn)
    {
        $sql = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE p_id = $productid";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) { // Corrected typo here
            $row = $result->fetch_assoc();
            return $row['avg_rating']; // Corrected column name here
        } else {
            return 0;
        }
    }

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM product WHERE id=$id";
    $result = $conn->query($sql);
    if  ($result->num_rows > 0){
        echo '<div class="container mt-4">';
        echo '<div class="row  row-cols-2 row-cols-md-3 g-5">';
        while ($row = $result->fetch_assoc()){
            $id = $row['id'];
            $name = $row['p_name'];
            $price = $row['p_price'];
            $description = $row['description'];
            $image = $row['image'];
            $date = $row['Date'];
            $finalImg = '../products/' . $image;

            $avgRating = calculateAverageRating($id, $conn);
            echo '<div class="col">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<img src="' . $finalImg . '" class="card-img-top" alt="Product Image" style="width: 18rem; height: 200px;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $name . '</h5>';
            echo '<p class="card-text">' . $description . '</p>';
            echo '<p class="card-text">Price: $' . $price . '</p>';
            echo '<p class="card-text">Average Rating: ' . number_format($avgRating, 1) . ' ';
            // Calculate the number of filled stars (including potentially half-filled stars) based on the average rating
            $numFilledStars = floor($avgRating); // Get the integer part
            $hasHalfStar = ($avgRating - $numFilledStars) >= 0.5; // Check if there is a half star
            // Loop to generate star icons
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $numFilledStars) {
                    // If the current star should be filled, display a gold star
                    echo '<i class="fas fa-star" style="color: gold;"></i>';
                } elseif ($i == $numFilledStars + 1 && $hasHalfStar) {
                    // If there is a half star, display a half-filled star
                    echo '<i class="fas fa-star-half-alt" style="color: gold;"></i>';
                } else {
                    // Otherwise, display an empty star
                    echo '<i class="far fa-star"></i>';
                }
            }
            echo '</p>';
            // Display average rating
            echo '<div class="d-flex justify-content-between">';
            echo '<a href="viewpost.php?id=' . $id . '" class="btn btn-primary view-post" >View full Post</a>';
            echo '<button type="button" class="btn btn-primary rate-review" data-toggle="modal" data-target="#reviewModal" data-id=" ' . $id . '">
            Rate & Review
            </button>';
            echo '</div>';
            echo '</div>'; // Close card-body
            echo '</div>'; // Close card
            echo '</div>'; // Close column
        }
        echo '</div>'; // Close row
        echo '</div>'; // Close container
        }
    }
else {
    echo "No id parameter provided.";
}
?>

 <!-- Modal -->
 <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Rate & Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Review form will be inserted here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Event listener for rate & review buttons
        $(document).ready(function() {
            $(".rate-review").click(function() {
                var productId = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "ajax/rate_review.php",
                    data: {
                        id: productId
                    },
                    success: function(response) {
                        $(".modal-body").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>





<div id="foot-content"></div>
</body>
</html>