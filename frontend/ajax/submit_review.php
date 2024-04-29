<?php
// Start session and include database configuration file
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if(!isset($_SESSION["mobile"])){
    $message = "Please login to comment or review a product";
    header("Location: ../login.php?message=" . urlencode($message));
    exit();
}

include("../../db_cofnfiguration/config.php");
// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mobile = $_SESSION["mobile"];
    $sql = "SELECT id FROM users where mobile = $mobile";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
        }
    }
    // Check if product ID and review are set
    if (isset($_POST['product_id']) && isset($_POST['review'])) {
        // Sanitize form data to prevent SQL injection
        $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
        $review = mysqli_real_escape_string($conn, $_POST['review']);
        $rating = mysqli_real_escape_string($conn, $_POST['rating']);

        $exist_sql = "SELECT * FROM reviews WHERE user_id = $id AND p_id = $productId";

        $exist_result = $conn->query($exist_sql);
        if ($exist_result->num_rows > 0) {
            while ($row = $exist_result->fetch_assoc()) {
                $review = $row['review'];
                // echo $review;
                $meassage =  "You have already submitted a review for this product.";
                header("Location: ../allprod.php?error=" . urlencode($meassage));
                exit();
            }
        }

        // Insert review into the database (you need to customize this query)
        $sql = "INSERT INTO reviews (user_id,p_id,review,rating) VALUES ('$id','$productId', '$review','$rating')";
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
