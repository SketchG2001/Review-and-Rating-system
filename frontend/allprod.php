<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// var_dump($_SESSION["mobile"]);
// exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/nav_footer.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="allprod.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
                    <!-- Bootstrap logo SVG -->
                </svg> & <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
                    <!-- Bootstrap logo SVG -->
                </svg>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="_home.php"><b>Home</b></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="allprod.php"><b>Products</b></a>
                    </li>
                    <?php
                    if (isset($_SESSION['mobile'])) {
                        echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="../backend/logout.php"><b>Log Out</b></a>
                    </li>';
                    } else {
                        echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php"><b>Login</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="SignUp.php"><b>Sign Up</b></a>
                    </li>';
                    }
                    ?>
                </ul>
                <?php
                include("../db_cofnfiguration/config.php");
                if (isset($_SESSION['mobile'])) {
                    $mobile = $_SESSION['mobile'];
                    $profile_sql = "SELECT * FROM users WHERE mobile = $mobile";
                    $user = $conn->query($profile_sql);
                    if ($user->num_rows > 0) {
                        while ($row = $user->fetch_assoc()) {
                            $image = $row["picture"];
                            $name = $row["Name"];
                            $finalImg = '../uploads/' . $image;
                            echo '
                        <div class="d-flex align-items-center">
                            <img src="' . $finalImg . '" class="rounded-circle img-fluid" alt="Profile Image" style="width: 40px; height: 40px; object-fit: cover;">
                            <span class="ms-2"><b>' . $name . '</b></span>
                        </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </nav>

    <?php
    if (isset($_GET['success'])) {
        $errorMessage = urldecode($_GET['success']);
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $errorMessage . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if (isset($_GET['error'])) {
        $errorMessage = urldecode($_GET['error']);
    ?>

        <!-- Bootstrap Alert with Dismiss Button -->
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    <?php
    }



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

    $sql = "SELECT * FROM product";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="container mt-4">';
        echo '<div class="row  row-cols-3 row-cols-md-4 g-5">';

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['p_name'];
            $price = $row['p_price'];
            $description = $row['description'];
            $image = $row['image'];
            $date = $row['Date'];
            $finalImg = '../products/' . $image;
            // echo $id;
            // exit();
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

            // echo $id;
            // exit();
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
    <!-- <div id="foot-content"></div> -->
</body>

</html>