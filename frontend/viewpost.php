<?php
session_start();
// var_dump($_SESSION["mobile"]);
// exit();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>


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
<style>
        .card-img-top {
            height: 200px; /* Set image height */
            object-fit: cover; /* Ensure image covers entire area */
        }
    </style>
<body>
<nav class="navbar navbar-expand-lg navbar bg-primary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="_home.php">Home</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link active" href="allprod.php">Products</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link active" href="SignUp.php">Sign Up</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="login.php">Login</a>
              </li>
              <?php
   
                if (isset($_SESSION['mobile'])) {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="../backend/logout.php">LogOut</a>
                    </li>';
                }
                ?>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
</nav>
    <?php
    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
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
    }

    function displayStarRating($rating) {
        // Calculate number of filled stars and half star
        $numFilledStars = floor($rating); // Number of full stars
        $hasHalfStar = ($rating - $numFilledStars) >= 0.5; // Check if there's a half star
    
        // Loop to generate star icons
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $numFilledStars) {
                // Full star icon
                echo '<i class="fas fa-star" style="color: gold;"></i>';
            } elseif ($i == $numFilledStars + 1 && $hasHalfStar) {
                // Half-filled star icon
                echo '<i class="fas fa-star-half-alt" style="color: gold;"></i>';
            } else {
                // Empty star icon
                echo '<i class="far fa-star"></i>';
            }
        }
    }
    



        $id = mysqli_real_escape_string($conn, $_GET['id']);

// Retrieve product details
$sql = "SELECT * FROM product WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display product details
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['p_name'];
        $price = $row['p_price'];
        $description = $row['description'];
        $image = $row['image'];
        $date = $row['Date'];
        $finalImg = '../products/' . $image;

        $avgRating = calculateAverageRating($id, $conn);

        // Display product details
        echo '<div class="container h-h-auto  ">';
        echo '<div class="row">';
        
        // Product details column (right side)
        echo '<div class="col-md-6 mb-4 mt-3">';
        echo '<div class="card">';
        echo '<img src="' . $finalImg . '" class="card-img-top" alt="Product Image" style="width: 100%; height: 350px;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $name . '</h5>';
        echo '<p class="card-text">' . $description . '</p>';
        echo '<p class="card-text">Price: $' . $price . '</p>';
        echo '<p class="card-text">Average Rating: ' . number_format($avgRating, 1) . ' ';
        displayStarRating($avgRating);
        // Display star ratings
        // $numFilledStars = floor($avgRating);
        // $hasHalfStar = ($avgRating - $numFilledStars) >= 0.5;
        // for ($i = 1; $i <= 5; $i++) {
        //     if ($i <= $numFilledStars) {
        //         echo '<i class="fas fa-star" style="color: gold;"></i>';
        //     } elseif ($i == $numFilledStars + 1 && $hasHalfStar) {
        //         echo '<i class="fas fa-star-half-alt" style="color: gold;"></i>';
        //     } else {
        //         echo '<i class="far fa-star"></i>';
        //     }
        // }

        echo '</p>';
        echo '<div class="d-flex justify-content-between">';
        echo '<a href="viewpost.php?id=' . $id . '" class="btn btn-primary view-post">View Full Post</a>';
        echo '<button type="button" class="btn btn-primary rate-review" data-toggle="modal" data-target="#reviewModal" data-id="' . $id . '">Rate & Review</button>';
        echo '</div>';
        echo '</div>'; // Close card-body
        echo '</div>'; // Close card
        echo '</div>'; // Close column (right side)

        // Comments column (left side)
        echo '<div class="col-md-6 col-auto mb-2 mt-3">';
        echo '<h5 class="card-title">Users feedback</h5>';
}       echo '<div class="comment-container" style="max-height: 65%; overflow-y: auto;">'; // Container for comments
        // Retrieve and display comments
        $sql_comments = "SELECT * FROM reviews WHERE p_id=$id";
        $result_comments = $conn->query($sql_comments);

        if ($result_comments->num_rows > 0) {
            while ($row_comment = $result_comments->fetch_assoc()) {
                $user_id = $row_comment["user_id"];
                $review = $row_comment["review"];
                $rating = $row_comment["rating"];
                $date = $row_comment["Date"];

                // Retrieve user details
                $sql_user = "SELECT * FROM users WHERE id=$user_id";
                $result_user = $conn->query($sql_user);

                if ($result_user->num_rows > 0) {
                    $row_user = $result_user->fetch_assoc();
                    $name = $row_user['Name'];
                    $img = $row_user['picture'];
                    $finalUserImg = '../uploads/' . $img;
                    echo '<div class="card">';
                    echo '<img src="' . $finalUserImg . '" class="card-img-top rounded-circle" alt="User Image" style="width: 50px; height: 50px;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $name . '</h5>';
                    echo '<span class="card-text">Review: ' . $review . '</span>';
                    echo '<span class="card-text">' . $date . '</span>';
                    echo '<p class="card-text">Rating: '.$rating .' ';
                    displayStarRating($rating);

                    echo '</p>';
                    echo '</div>'; // Close card-body
                    echo '</div>'; // Close card
                    

                }
            }
        }
        echo '</div>'; // Close card
        echo '</div>'; // Close card

    }

$escaped_id = $conn->real_escape_string($id);

    $sql = "SELECT * FROM product WHERE id <> $escaped_id";

    $allprod = $conn->query($sql);

    if ($allprod->num_rows > 0) {
        echo '<div class="container  mt-4">';
        echo '<div class="row  row-cols-2 row-cols-md-4 g-5">';
        while ($row = $allprod->fetch_assoc()) {
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
        echo '<br>';
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