<?php
// Function to generate a star HTML element
function generateStar($rating) {
    // Check if rating is within range (0 to 5)
    if ($rating < 0 || $rating > 5) {
        return "Invalid rating";
    }

    // Calculate the width of the filled star
    $filledWidth = ($rating / 5) * 100;

    // Generate HTML code for the star
    $starHTML = '<div class="star-rating">';
    $starHTML .= '<div class="star-rating-inner" style="width: ' . $filledWidth . '%;"></div>';
    $starHTML .= '</div>';

    return $starHTML;
}

// Example usage
$rating = 4.5; // Example rating
echo generateStar($rating);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .star-rating {
    display: inline-block;
    font-size: 0;
    white-space: nowrap;
    overflow: hidden;
    position: relative;
}

.star-rating-inner {
    display: inline-block;
    font-size: 16px; /* Adjust the size of the star */
    position: relative;
    white-space: nowrap;
    overflow: hidden;
    width: 100%;
}

.star-rating-inner:before {
    content: "★★★★★"; /* Unicode character for a solid star */
    color: gold; /* Color of the filled star */
    position: absolute;
    top: 0;
    left: 0;
    white-space: nowrap;
}

.star-rating-inner:after {
    content: "★★★★★"; /* Unicode character for an empty star */
    color: lightgray; /* Color of the empty star */
    position: absolute;
    top: 0;
    left: 0;
    white-space: nowrap;
}

</style>
<body>
    
</body>
</html>