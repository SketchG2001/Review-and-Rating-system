<?php

session_start();
include("../db_cofnfiguration/config.php");

function validateFormData($mobile, $password) {

    $mobileValidation = validateMobile($mobile);
    if ($mobileValidation !== true) {
        return $mobileValidation;
    }


    $passwordValidation = validatePassword($password);
    if ($passwordValidation !== true) {
        return $passwordValidation;
    }
    return true;
}


function validateMobile($mobile) {
    if (empty($mobile)) {
        return "Mobile number cannot be empty.";
    }
    if (!preg_match('/^\d{10}$/', $mobile)) {
        return 'Invalid mobile number. Please enter a 10-digit number.';
    }

    return true;
}


function validatePassword($password) {
    if (empty($password)) {
        return "Password cannot be empty.";
    }
    // Additional validation logic for password can be added here if needed

    return true;
}

// Validate form data upon form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    echo $mobile . "<br>";
    echo $password ."<br>";


    // Validate form data
    $validationResult = validateFormData($mobile, $password);
    if ($validationResult !== true) {
        // Validation failed, display error message
            header("Location: ../frontend/login.php?error=" . urlencode($validationResult));
            exit();
    }else{
       
        // Prepare the statement
$stmt = $conn->prepare("SELECT * FROM users WHERE mobile=?");

// Check if prepare was successful
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the parameter (assuming $mobile is a string)
$stmt->bind_param("s", $mobile);

// Execute the statement
if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

// Get the result set
$result = $stmt->get_result();

// Check the number of rows in the result set
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hashed_password = $row["password"];
    
    if (password_verify($password,$hashed_password)){
        $_SESSION["mobile"] = $mobile;
        header("Location: ../frontend/welcome.php");
        exit();
    }

} else {
    echo "No user found";
}

// Close the statement
$stmt->close();

    }




}


?>