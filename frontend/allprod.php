<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="js/nav_footer.js" ></script>
</head>
<body>
<div id="nav-content"></div>

<?php
include("../db_cofnfiguration/config.php");

$sql = "SELECT * FROM product";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<div class="row  row-cols-2 row-cols-md-3 g-5">';

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $name = $row['p_name'];
    $price = $row['p_price'];
    $description = $row['description'];
    $image = $row['image'];
    $date = $row['Date'];
    $finalImg = '../products/' . $image;

    echo '<div class="col">';
    echo '<div class="card" style="width: 18rem;">';
    echo '<img src="' . $finalImg . '" class="card-img-top" alt="Product Image" style="width: 18rem; height: 200px;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $name . '</h5>';
    echo '<p class="card-text">' . $description . '</p>';
    echo '<p class="card-text">Price: $' . $price . '</p>';
    // Button group for actions
    echo '<div class="d-flex justify-content-between">';
    echo '<a href="#" class="btn btn-primary">Like</a>';
    echo '<a href="#" class="btn btn-primary">Comment</a>';
    echo '<a href="#" class="btn btn-primary">share</a>';
    echo '</div>';
    echo '</div>'; // Close card-body
    echo '</div>'; // Close card
    echo '</div>'; // Close column
}

echo '</div>'; // Close row
echo '</div>'; // Close container

}












?>










<div id="foot-content" class="mt-lg-3 "></div>
</body>
</html>