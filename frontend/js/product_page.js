$(document).ready(function(){
    // Event listener for star rating selection
    $(document).on('click', '.star', function(){
        var rating = $(this).data("rating");
        $(".star").removeClass("selected");
        $(this).addClass("selected");
        $(".rating-value").val(rating);
    });

    // Event listener for hovering over stars
    $(document).on('mouseenter', '.star', function(){
        var rating = $(this).data("rating");
        $(this).parent().find('.star').each(function(){
            if ($(this).data('rating') <= rating) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });
    });

    $(document).on('mouseleave', '.star', function(){
        $(this).parent().find('.star').removeClass('hover');
    });

    // Rate & Review button click event
    $('.rate-review').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        
        // Check if the user is logged in
        if (userIsLoggedIn()) {
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
        } else {
            // If user is not logged in, redirect to login page
            window.location.href = 'login.php';
        }
    });

    // Event listener for form submission
    $(document).on('submit', '#reviewForm', function(event){
        event.preventDefault(); // Prevent default form submission
        
        // Check if the user is logged in
        if (userIsLoggedIn()) {
            // Serialize form data
            var formData = $(this).serialize();
            
            // Send AJAX request to submit the form data
            $.ajax({
                url: 'ajax/submit_review.php', // Update with your PHP file to handle form submission
                type: 'POST',
                data: formData, // Include form data
                success: function(response){
                    // Handle success, e.g., show a success message
                    console.log(response);
                    // Optionally, hide or close the modal
                    $('#reviewModal').modal('hide');
                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(error);
                    // Optionally, show an error message to the user
                }
            });
        } else {
            // If user is not logged in, redirect to login page
            window.location.href = 'login.php';
        }
    });

    // Function to check if the user is logged in
  
});
