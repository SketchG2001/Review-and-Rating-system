<?php
// Start session and include database configuration file
session_start();
// var_dump($_SESSION);
// exit();
include("../../db_cofnfiguration/config.php");

// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if product ID and review are set
    if (isset($_POST['product_id']) && isset($_POST['review'])) {
        // Sanitize form data to prevent SQL injection
        $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
        $review = mysqli_real_escape_string($conn, $_POST['review']);
        $rating = mysqli_real_escape_string($conn, $_POST['rating']);

        // echo $productId ."<br>";
        // echo $review ."<br>";
        // echo $rating;

        // exit();
        // Insert review into the database (you need to customize this query)
        $sql = "INSERT INTO reviews (p_id,review,rating) VALUES ('$productId', '$review','$rating')";
        if ($conn->query($sql) === TRUE) {
            // If review is successfully inserted, return success message
            $success_message = "Review submitted successfully.";
            header("Location: ../allprod.php?success=" . urlencode($success_message));
            exit();
        } else {
            // If there is an error, return error message
            echo 'Error: ' . $sql . '<br>' . $conn->error;
        }
    } else {
        // If product ID or review is not set, return error message
        echo 'Product ID or review is not provided.';
    }
} else {
    // If form data is not submitted via POST, return error message
    echo 'Form data is not submitted.';
}
?>
