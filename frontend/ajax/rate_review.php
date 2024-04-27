<?php
// Include your database configuration file
include("../../db_cofnfiguration/config.php");

// Check if the ID parameter is sent via POST
if(isset($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // You can fetch the product details if needed
    $sql = "SELECT * FROM product WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Now you can use $row to display product details or create a review form
        // For demonstration purposes, let's create a simple review form
        $product_name = $row['p_name'];

        // HTML markup for the review form with star ratings
        $form_html = '
            <h3>Rate & Review for '.$product_name.'</h3>
            <form id="reviewForm">
                <div class="form-group">
                    <label for="review">Your Review:</label>
                    <textarea class="form-control" id="review" name="review" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <div class="rating">
                        <span class="star" data-rating="1">&#9733;</span>
                        <span class="star" data-rating="2">&#9733;</span>
                        <span class="star" data-rating="3">&#9733;</span>
                        <span class="star" data-rating="4">&#9733;</span>
                        <span class="star" data-rating="5">&#9733;</span>
                        <input type="hidden" name="rating" class="rating-value" value="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Submit Review</button>
            </form>';

        // JavaScript for star rating selection
        $script = '
            <script>
                $(document).ready(function(){
                    $(".star").click(function(){
                        var rating = $(this).data("rating");
                        $(".star").removeClass("selected");
                        $(this).addClass("selected");
                        $(".rating-value").val(rating);
                    });
                });
            </script>';

        // Return the form HTML and JavaScript
        echo $form_html . $script;
    } else {
        // If product not found, return an error message
        echo 'Product not found';
    }
} else {
    // If ID parameter is not sent, return an error message
    echo 'ID parameter not provided';
}
?>
