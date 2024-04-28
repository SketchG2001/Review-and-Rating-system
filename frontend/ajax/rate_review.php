<?php
// Start session and include database configuration file
session_start();
include("../../db_cofnfiguration/config.php");

// Check if product ID is set via POST
if (isset($_POST['id'])) {
    // Sanitize product ID to prevent SQL injection
    $productId = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = "SELECT * FROM product WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Generate review form HTML with rating stars
        $reviewForm = '
            <h3>Rate & Review for '.$row['p_name'].'</h3>
            <form id="reviewForm" method="post" action="ajax/submit_review.php">
                <input type="hidden" name="product_id" value="' . $productId . '">
                <div class="form-group">
                    <label for="review">Your Review:</label>
                    <textarea class="form-control" id="review" name="review" rows="3"></textarea>
                </div>
                <div class="form-group">
                <div id="error" class=""><b></b></div>
                    <label for="rating">Rating:</label>
                    <div class="rating">
                        <span class="star" data-rating="1"><i class="fas fa-star"></i></span>
                        <span class="star" data-rating="2"><i class="fas fa-star"></i></span>
                        <span class="star" data-rating="3"><i class="fas fa-star"></i></span>
                        <span class="star" data-rating="4"><i class="fas fa-star"></i></span>
                        <span class="star" data-rating="5"><i class="fas fa-star"></i></span>
                        <input type="hidden" name="rating" id="rating" class="rating-value" value="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Submit Review</button>
            </form>
        ';

        // Return review form HTML
        echo $reviewForm;
    } else {
        echo "No product found with the given ID.";
    }
} else {
    // If product ID is not set, return an error message
    echo 'Product ID is not provided.';
}
?>
<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script>
    $(document).ready(function() {
        // Function to validate the review form
        function validateForm() {
            var review = $('#review').val();
            var rating = $('#rating').val();
            // Check if review is empty
            if (review.trim() === '') {
                $('#error b').text('Please enter your review');
                // document.getElementById("error").innerHTML = "";
                // alert('Please enter your review.');
                return false;
            }
            // Check if rating is not selected
            if (rating == '') {
                alert('Please select a rating.');
                return false;
            }
            return true; // Form is valid
        }

        // Event listener for form submission
        $('#reviewForm').submit(function(e) {
            // Prevent default form submission
            e.preventDefault();
            // Validate the form
            if (validateForm()) {
                // If form is valid, submit the form
                $(this).unbind('submit').submit();
            }
        });

        // Event listener for hovering over star icons
        $('.star').hover(function() {
            var rating = $(this).data('rating');
            // Highlight stars up to the one being hovered over
            $('.star').css('color', 'gray');
            $('.star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).css('color', 'gold');
                }
            });
        }, function() {
            // Reset star colors when mouse leaves
            $('.star').css('color', 'gray');
            // Set gold color for selected stars
            var rating = $('#rating').val();
            $('.star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).css('color', 'gold');
                }
            });
        });

        // Event listener for clicking on star icons
        $('.star').click(function() {
            var rating = $(this).data('rating');
            $('#rating').val(rating);
            // Set gold color for selected stars
            $('.star').css('color', 'gray');
            $('.star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).css('color', 'gold');
                }
            });
        });
    });
</script>


<!-- <script>
    $(document).ready(function() {
        // Event listener for hovering over star icons
        $('.star').hover(function() {
            var rating = $(this).data('rating');
            // Highlight stars up to the one being hovered over
            $('.star').css('color', 'gray');
            $('.star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).css('color', 'gold');
                }
            });
        }, function() {
            // Reset star colors when mouse leaves
            $('.star').css('color', 'gray');
            // Set gold color for selected stars
            var rating = $('#rating').val();
            $('.star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).css('color', 'gold');
                }
            });
        });

        // Event listener for clicking on star icons
        $('.star').click(function() {
            var rating = $(this).data('rating');
            $('#rating').val(rating);
            // Set gold color for selected stars
            $('.star').css('color', 'gray');
            $('.star').each(function() {
                if ($(this).data('rating') <= rating) {
                    $(this).css('color', 'gold');
                }
            });
        });
    });
</script> -->
<style>
    #error b {
    color: red;
}
</style>