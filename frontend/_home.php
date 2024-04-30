<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="allprod.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
          <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.8 6.8 0 0 0 1.16 8z" />
          <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324z" />
        </svg> & <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
          <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.8 6.8 0 0 0 1.16 8z" />
          <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324z" />
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
                            <a class="nav-link active" href="../backend/logout.php"><b>LogOut</b></a>
                        </li>';
          } else {
            // User is not logged in, show Login and Sign Up links
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
<hr>
  <div class="container" style="width: 100%;">
    <div id="carouselExampleIndicators"  class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner"  >

        <?php
        include("../db_cofnfiguration/config.php");

        function calculateAverageRating($productid, $conn)
        {
          $sql = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE p_id = $productid";
          $result = $conn->query($sql);
          if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['avg_rating'];
          } else {
            return 0;
          }
        }
        function displayStarRating($rating)
        {
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


        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $firstItem = true; // Flag to mark the first carousel item as active

          while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['p_name'];
            $price = $row['p_price'];
            $description = $row['description'];
            $image = $row['image'];
            $finalImg = '../products/' . $image;
            $avgRating = calculateAverageRating($id, $conn);

            // Determine if the current item should be the active one
            $activeClass = $firstItem ? 'active' : '';
            $firstItem = false; // Disable active for subsequent items

            // Output the carousel item with PHP variables
            echo '
<div class="carousel-item ' . $activeClass . '">
    <img src="' . $finalImg . '" class="d-block w-100" style="height: 500px;" alt="' . $name . '">
    <div class="carousel-caption d-none d-md-block">
        <h5>' . $name . '</h5>
        <p>' . $description . '</p>
        <p>Price: $' . $price . '</p>
        <p class="card-text">Average Rating: ' . number_format($avgRating, 1) . '</p>';

            // Display star rating based on average rating
            echo '<div>';
            displayStarRating($avgRating);
            echo '</div>';

            echo '
    </div>
</div>';
          }
        }
        ?>

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="container" style="position: relative;">
    <div class="col-10">
      <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta sed autem cupiditate quia ab tenetur, provident corporis ipsum quo voluptate beatae ut voluptas unde laboriosam! Modi perspiciatis eligendi, perferendis necessitatibus dolorem accusantium aliquam voluptatibus laboriosam et debitis reiciendis eos dicta voluptates quidem quam asperiores excepturi sint expedita! Placeat, accusamus doloremque.</h1>
    </div>
  </div>

  <!-- Bootstrap JS bundle (Popper.js included) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>