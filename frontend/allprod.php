<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
    echo '<a href="#"  class="btn btn-primary view-post" data-id="' . $id . '">View full Post</a>';
    echo '<a href="#"  class="btn btn-primary rate-review" data-id="' . $id . '">rate & review</a>';
    echo '</div>';
    echo '</div>'; // Close card-body
    echo '</div>'; // Close card
    echo '</div>'; // Close column
}
echo '</div>'; // Close row
echo '</div>'; // Close container

}
?>

<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-md-11 text-right">
                        <h5 class="modal-title" id="reviewModalLabel">Rate & Review</h5>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <!-- Review form will be inserted here -->
                <!-- You'll insert the form via AJAX -->
            </div>
        </div>
    </div>
</div>





<script>
$(document).ready(function(){
    // View full Post button click event
    $('.view-post').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        // AJAX request to fetch full post content
        $.ajax({
            url: 'ajax/view_post.php', // Update with your PHP file to handle the request
            type: 'POST',
            data: { id: id },
            success: function(response){
                // Handle response, e.g., display post content in a modal
                console.log(response);
            },
            error: function(xhr, status, error){
                // Handle errors
                console.error(error);
            }
        });
    });

    // Rate & Review button click event
    $('.rate-review').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        
        // AJAX request to fetch the review form
        $.ajax({
            url: 'ajax/rate_review.php',
            type: 'POST',
            data: { id: id },
            success: function(response){
                // Insert the form HTML into a hidden modal
                $('#reviewModal .modal-body').html(response);
                // Show the modal
                $('#reviewModal').modal('show');
            },
            error: function(xhr, status, error){
                // Handle errors
                console.error(error);
            }
        });
    });
});
</script>









<div id="foot-content" class="mt-lg-3 "></div>
</body>
</html>