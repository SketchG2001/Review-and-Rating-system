<?php
// Include your database configuration file
include("../../db_cofnfiguration/config.php");

// Check if the ID parameter is sent via POST
if(isset($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Query to fetch the post content based on the ID
    $sql = "SELECT * FROM product WHERE id = $id";

    // Perform the query
    $result = $conn->query($sql);

    // Check if there is a result
    if ($result->num_rows > 0) {
        // Fetch the data
        $row = $result->fetch_assoc();
        // You can format the data as needed and send it back as a JSON response
        $response = array(
            'status' => 'success',
            'post' => $row
        );
        echo json_encode($response);
    } else {
        // If no post found, send an error response
        $response = array(
            'status' => 'error',
            'message' => 'Post not found'
        );
        echo json_encode($response);
    }
} else {
    // If ID parameter is not sent, send an error response
    $response = array(
        'status' => 'error',
        'message' => 'ID parameter not provided'
    );
    echo json_encode($response);
}
?>
